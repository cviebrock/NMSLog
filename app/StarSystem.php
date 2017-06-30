<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class StarSystem extends Model
{

    protected static $galacticCenterCoordinates = 'GCTR:07FF:007F:07FF:0000';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'star_system_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'class',
        'coordinates',
        'gc_distance',
        'planets',
        'moons',
        'black_hole',
        'atlas_interface',
        'notes',
        'user_id',
        'discovered_on',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'discovered_on',
    ];

    /**
     * These may eventually go away because they may be able
     * to be determined from the star's spectral class.
     *
     * @var array
     */
    public static $colors = [
        'X' => 'unknown / none',
        'O' => 'blue',
        'B' => 'blue-white',
        'A' => 'white',
        'F' => 'yellow-white',
        'G' => 'yellow',
        'K' => 'orange',
        'M' => 'red',
        'L' => 'red-brown',
        'T' => 'brown',
        'Y' => 'dark-brown',
        'E' => 'green',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function discovered_by() :BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @param string $value
     *
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     */
    public function setCoordinatesAttribute(string $value)
    {
        $this->attributes['coordinates'] = strtoupper($value);

        $pos = self::parseCoordinates($value);

        $this->forceFill($pos);
    }

    /**
     * @param string $string
     */
    public function setClassAttribute(string $string)
    {
        $this->attributes['class'] = ucfirst(strtolower($string));
    }

    /**
     * @param string $value
     *
     * @return array
     */
    public static function parseCoordinates(string $value) :array
    {
        list(, $pos_x, $pos_y, $pos_z, $pos_w) = explode(':', $value);

        $pos = compact('pos_x', 'pos_y', 'pos_z', 'pos_w');

        return array_map(function($v) {
            return hexdec($v);
        }, $pos);
    }

    /**
     * @return array
     */
    public function getCoordinateArrayAttribute() :array
    {
        return array_only($this->attributes, ['pos_x', 'pos_y', 'pos_z', 'pos_w']);
    }

    /**
     * @return array
     */
    public function getXYZArrayAttribute() :array
    {
        return [
            $this->attributes['pos_x'],
            $this->attributes['pos_y'],
            $this->attributes['pos_z'],
        ];
    }

    /**
     * @return string
     */
    public function getDescriptionAttribute() :string
    {
        if ($this->atlas_interface) {
            $description = 'Atlas Interface';
        } else if ($this->black_hole) {
            $description = 'Black hole';
        } else {
            $description = $this->class;
        }

        if ($planets = $this->planets) {
            $description .= ' // ' . $planets . ' ' . str_plural('planet', $planets);
        }
        if ($moons = $this->moons) {
            $description .= ' // ' . $moons . ' ' . str_plural('moon', $moons);
        }

        return $description;
    }

    /**
     * @return string
     */
    public function getColorAttribute()
    {
        $class = strtoupper(substr(array_get($this->attributes, 'class', 'X'), 0, 1));

        return array_key_exists($class, static::$colors) ? $class : 'X';
    }

    /**
     * @return int
     */
    public function getBrightnessAttribute() :int
    {
        if ($class = array_get($this->attributes, 'class')) {
            if (preg_match('/^[A-Z](\d+)/', $class, $matches)) {
                return (int) $matches[1];
            }
        }

        return 5;
    }

    /**
     * @param string $timezone
     *
     * @return mixed
     */
    public function discoveredOnInTimezone(string $timezone) :Carbon
    {
        /** @var Carbon $date */
        return $this->getAttribute('discovered_on')
            ->setTimezone($timezone);
    }

    /**
     * @return $this
     */
    public function updateDistance()
    {
        if ($this->getAttribute('gc_distance') === null) {

            $this->setAttribute('gc_distance', $this->distanceTo(self::$galacticCenterCoordinates));
        }

        return $this;
    }

    /**
     * @param string|\App\StarSystem $other
     *
     * @return float
     * @throws \InvalidArgumentException
     */
    public function distanceTo($other) :float
    {
        if ($other instanceof StarSystem) {
            $o = $other->coordinateArray;
        } elseif (is_string($other)) {
            $o = static::parseCoordinates($other);
        } else {
            throw new \InvalidArgumentException('Argument passed to distanceTo must be a string or a StarSystem object');
        }

        $d = $this->coordinateArray;

        $dx = ($d['pos_x'] - $o['pos_x']);
        $dy = ($d['pos_y'] - $o['pos_y']);
        $dz = ($d['pos_z'] - $o['pos_z']);

        return sqrt(($dx ** 2) + ($dy ** 2) + ($dz ** 2)) * 100.0;
    }
}
