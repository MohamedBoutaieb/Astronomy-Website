import { OrbitControls } from '../node_modules/three/examples/jsm/controls/OrbitControls.js';

var scene = new THREE.Scene();
var camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight);
camera.position.z = 10;

var renderer = new THREE.WebGLRenderer({ antialias: true});
renderer.setSize(window.innerWidth, window.innerHeight);
document.body.append(renderer.domElement);

//Adaptive Resolution
window.addEventListener("resize", onResize);
function onResize(event) {
    renderer.setSize(window.innerWidth, window.innerHeight);
    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();
}
//Global variables
var moons = [];
var globes;
//Raycaster
const raycaster = new THREE.Raycaster();
const mouse = new THREE.Vector2();

var textureLoader = new THREE.TextureLoader();
textureLoader.load('../images/space2.jpg', function (texture){
         texture.mapping = THREE.EquirectangularReflectionMapping;
         texture.encoding = THREE.sRGBEncoding;
         scene.background = texture;
});


//init Scene
var init = () => {

    //Orbit controls
    var controls = new OrbitControls(camera, renderer.domElement);
    controls.minDistance = 2;
    controls.maxDistance = 20;
    controls.enablePan = false;
    controls.enableDamping = true;
    controls.dampingFactor = 0.05;

    //init light
    // const directionalLight = new THREE.DirectionalLight(0xfffff1, 1);
    // directionalLight.position.set(2, 4, 4);
    // scene.add(directionalLight);

    //init globes
    var sun = new Globe(new THREE.Vector3(0, 0, 0), 10, scene, 0);
    //sun.sphere.material.emissive = new THREE.Color(0xFF4411);;
    globes = [sun];
    globes.forEach(globe => {
        globe.update();
    });
    sun.sphere.material.normalMap = normalTexture;
    //init point lights
    async function sunPoints(){
        for (let teta = 0; teta < 2 * Math.PI; teta += 3.14/ 6) {
            for (let gamma = 0; gamma <  Math.PI; gamma += 3.14 / 6) {
                let position = new THREE.Vector3(1, 0, 0);
                position.multiplyScalar(1.001);
                position.applyAxisAngle(new THREE.Vector3(0, 1, 0), teta);
                position.applyAxisAngle(new THREE.Vector3(0, 0, 1), gamma);
                let pointlight = new THREE.PointLight(0xFFFFCC, 0.01);
                pointlight.position.set(position.x, position.y, position.z);
                scene.add(pointlight);
            }
        }
    }
    sunPoints();


    //init solar system

    //Mercury 2.5
    var mercury = new Moon(new THREE.Vector3(0, 0, 2), new THREE.Vector3(0.002, 0, 0), 0.1, globes, scene);
    moons.push(mercury);
    //normalTexture = textureLoader.load('assets/Mercury.png');
    //mercury.sphere.material.normalMap = normalTexture;

    //Venus 3 * 2.5
    var venus = new Moon(new THREE.Vector3(0, 0, 2.5), new THREE.Vector3(0.003, 0, 0), 0.3, globes, scene);
    moons.push(venus);
    //normalTexture = textureLoader.load('assets/venus.png');
    //mercury.sphere.material.normalMap = normalTexture;

    //Earth 6.5
    var earth = new Moon(new THREE.Vector3(0, 0, 3), new THREE.Vector3(0.003, 0, 0), 0.32, globes, scene);
    moons.push(earth);
    //earth.sphere.material.map = THREE.ImageUtils.loadTexture('assets/Earth.jpg');
    //normalTexture = textureLoader.load('assets/Earth.jpg');
    //mercury.sphere.material.normalMap = normalTexture;

    //Mars 3.2
    moons.push(new Moon(new THREE.Vector3(0, 0, 3.3), new THREE.Vector3(0.002, 0, 0), 0.15, globes, scene));

    //Jupiter 70
    moons.push(new Moon(new THREE.Vector3(0, 0, 5), new THREE.Vector3(0.005, 0, 0), 1.5, globes, scene));

    //Saturn 58
    moons.push(new Moon(new THREE.Vector3(0, 0, 5.7), new THREE.Vector3(0.004, 0, 0), 1, globes, scene));

    //Uranus 25
    moons.push(new Moon(new THREE.Vector3(0, 0, 6.5), new THREE.Vector3(0.003, 0, 0), 0.7, globes, scene));

    //Nepture 24
    moons.push(new Moon(new THREE.Vector3(0, 0, 7), new THREE.Vector3(0.003, 0, 0), 0.65, globes, scene));
}
init();

//Array for raycasting the mouse position
const meshs = scene.children.filter(object => {
    try {
        return object.geometry.type == "SphereGeometry";
    } catch (error) {
        return false;
    }
});


//onMouseMove event listener 
function onMouseMove(event) {
    mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
    mouse.y = - (event.clientY / window.innerHeight) * 2 + 1;
    // camera.position.x = mouse.x * 10;
    // camera.position.y = mouse.y * 10;
}
renderer.domElement.addEventListener('mousemove', onMouseMove, false);

//On click event listener
var camTarget = globes[0].position;
window.addEventListener('click', onClick, false);
function onClick(event) {
    raycaster.setFromCamera(mouse, camera);
    var intersects = raycaster.intersectObjects(meshs);
    if (intersects.length == 0) {
        camTarget = globes[0].position;
        scroll = false;
    }
    else {
        camTarget = intersects[0].object.position;
        camera.lookAt(camTarget);
        scroll = true;
    }

}

//On keydown event listener
document.addEventListener("keydown", onDocumentKeyDown, false);
function onDocumentKeyDown(event) {
    var keyCode = event.which;
    var direction = new THREE.Vector3();
    camera.getWorldDirection(direction).normalize();
    if (keyCode == 37) {
    } if ([38, 90].includes(keyCode)) {
        camera.position.add(direction.clone().multiplyScalar(0.1));
    } if ([40, 83].includes(keyCode)) {
        camera.position.add(direction.clone().negate().multiplyScalar(0.1));
    }
};
//On mouse down event listener 
function onMouseDown(event){
    console.log("mouedown");
    if(event.type =="mousedown")
        console.log("MouseDown");
}
renderer.domElement.addEventListener('mousedown', onMouseDown)

//Main loop
var animate = function () {
    globes.forEach(globe => {
        globe.sphere.rotation.y += 0.005;
    });
    moons.forEach(moon => {
        moon.update();
    });
    camera.lookAt(camTarget);
    renderer.render(scene, camera);
    requestAnimationFrame(animate);
};
animate();
