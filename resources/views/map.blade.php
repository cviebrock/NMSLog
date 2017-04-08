@extends('layouts.app')

@section('head')
    <script src="https://threejs.org/build/three.js"></script>
    <script src="https://threejs.org/examples/js/controls/OrbitControls.js"></script>

    {{--<script type="text/javascript" src="http://canvg.github.io/canvg/rgbcolor.js"></script>--}}
    {{--<script type="text/javascript" src="http://canvg.github.io/canvg/StackBlur.js"></script>--}}
    {{--<script type="text/javascript" src="http://canvg.github.io/canvg/canvg.js"></script>--}}

    <script>
        var starSystems = {!! json_encode($starSystems, JSON_PRETTY_PRINT) !!};
        var path = {!! json_encode($path, JSON_PRETTY_PRINT) !!};
        var starSystemColors = {
            O: 0x6685FF,  // blue
            B: 0xB2C2FF, // blue-white
            A: 0xFFFFFF, // white
            F: 0xFEF9D2, // yellow-white
            G: 0xFDF4A5, // yellow
            K: 0xFB965C, // orange
            M: 0xFA3914, // red
            L: 0xE65E2F, // red-brown
            T: 0xD2844B, // brown
            Y: 0x8B4513, // dark brown
            E: 0x33B259, // green
            X: 0x999999, // ?
        };
    </script>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h1>Current Map</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div id="map"></div>
                <script>

                    var moveTo = function (object, position) {
                        if (Array.isArray(position)) {
                            object.position.set(position[0], position[1], position[2]);
                        } else {
                            object.position.x = position.x;
                            object.position.y = position.y;
                            object.position.z = position.z;
                        }
                    };

                    // set up the various things
                    var element = document.getElementById('map'),
                      dimension = element.getBoundingClientRect().width,
                      scene = new THREE.Scene(),
                      camera = new THREE.PerspectiveCamera(75, 1, 1, 0xffff),
                      renderer = new THREE.WebGLRenderer({antialias: true}),
                      clock = new THREE.Clock();

                    renderer.setPixelRatio(window.devicePixelRatio);
                    renderer.setSize(dimension, dimension);
                    element.appendChild(renderer.domElement);

                    var controls = new THREE.OrbitControls(camera, renderer.domElement);

                    // some constant variables
                    var colors = {
                        gridLight:  0x99bbcc,
                        gridMedium: 0x6b828e,
                        gridDark:   0x3d4a51,
                    };

                    var galacticCenterArray = [0x07ff, 0x007f, 0x07ff],
                      galacticCenterVector = new THREE.Vector3().fromArray(galacticCenterArray);

                    // set up the grid
                    // var galacticGrid = new THREE.PolarGridHelper(0x07ff, 36, 12, 64, colors.gridDark, colors.gridMedium);
                    var galacticGrid = new THREE.GridHelper(0x0fff, 32, colors.gridMedium, colors.gridDark);
                    //                    moveTo(galacticGrid, galacticCenterVector);
                    scene.add(galacticGrid);

                    // add stars

                    var starGeometry = new THREE.Geometry(),
                      starTexture = new THREE.TextureLoader().load('/img/star.png'),
                      starColors = [];

                    for (var i = 0; i < starSystems.length; i++) {
                        var starSystem = starSystems[i],
                          color = starSystemColors[starSystem.color],
                          position = starSystem.position,
                          brightness = starSystem.brightness,
                          geometry = new THREE.SphereGeometry(1+brightness/10, 32, 32),
                          material = new THREE.MeshBasicMaterial({
                              color: color,
                              reflectivity: 0,
                              opacity: 0.5,
                              transparent: true,
                          });
                        var sphere = new THREE.Mesh( geometry, material );


                        sphere.position.x = position[0] - galacticCenterVector.x;
                        sphere.position.y = position[1] - galacticCenterVector.y;
                        sphere.position.z = position[2] - galacticCenterVector.z;
                        scene.add(sphere);
                    }

                    // position camera
                    camera.position.y = 0x0fff;

                    // render
                    var render = function () {
                        requestAnimationFrame(render);
                        renderer.render(scene, camera);
                        controls.update();
                    };

                    render();
                </script>
            </div>
        </div>
    </div>
@endsection
