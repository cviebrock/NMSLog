<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


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
        'color',
        'coordinates',
        'gc_distance',
        'planets',
        'moons',
        'black_hole',
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
    public function discovered_by()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @param string $value
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     */
    public function setCoordinatesAttribute(string $value)
    {
        $this->attributes['coordinates'] = strtoupper($value);

        $pos = self::parseCoordinates($value);

        $this->forceFill($pos);
    }

    /**
     * @param string $value
     * @return array
     */
    public static function parseCoordinates(string $value)
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
    public function getCoordinateArrayAttribute()
    {
        return array_only($this->attributes, ['pos_x', 'pos_y', 'pos_z', 'pos_w']);
    }

    /**
     * @return string
     */
    public function getDescriptionAttribute()
    {
        $description = $this->black_hole ? 'Black hole' : $this->class;

        if ($this->planets) {
            $description .= ' // ' . $this->planets . ' ' . str_plural('planet', $this->planets);
        }
        if ($this->moons) {
            $description .= ' // ' . $this->moons . ' ' . str_plural('moon', $this->moons);
        }

        return $description;
    }

    /**
     * @param string $timezone
     * @return mixed
     */
    public function discoveredOnInTimezone(string $timezone)
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
     * @return float
     * @throws \InvalidArgumentException
     */
    public function distanceTo($other)
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
