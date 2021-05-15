import { OrbitControls } from '../modules/three/examples/jsm/controls/OrbitControls.js';
import { GUI } from '../modules/three/examples/jsm/libs/dat.gui.module.js';

let scene = new THREE.Scene();
let camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight);
camera.position.z = 9;
camera.position.y = 4;

let renderer = new THREE.WebGLRenderer({ antialias: true });
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
let moons = [];
let globes = [];

//Raycaster
const raycaster = new THREE.Raycaster();
const mouse = new THREE.Vector2();

//space background
let textureLoader = new THREE.TextureLoader();
textureLoader.load('../images/space2.jpg', function (texture) {
    texture.mapping = THREE.EquirectangularReflectionMapping;
    texture.encoding = THREE.sRGBEncoding;
    scene.background = texture;
});

//params
let sandboxMode = false;
let params = {
    sandboxMode: startSandboxMode,
    globe: false,
    size: 3,
    reset: initSolarSystem
}

function initSolarSystem() {
    moons.forEach(moon => {
        scene.remove(moon.sphere);
        scene.remove(moon.line);
    })
    globes.forEach(globe => {
        if (globes.indexOf(globe))
            scene.remove(globe.sphere);
    })
    globes.splice(1, globes.length - 1);
    moons = [];
    //Mercury 2.5
    let mercury = new Moon(new THREE.Vector3(0, 0, 2), new THREE.Vector3(0.002, 0, 0), 0.1, globes, moons, scene);
    moons.push(mercury);
    //normalTexture = textureLoader.load('assets/Mercury.png');
    //mercury.sphere.material.normalMap = normalTexture;

    //Venus 3 * 2.5
    let venus = new Moon(new THREE.Vector3(0, 0, 2.5), new THREE.Vector3(0.003, 0, 0), 0.3, globes, moons, scene);
    moons.push(venus);
    //normalTexture = textureLoader.load('assets/venus.png');
    //mercury.sphere.material.normalMap = normalTexture;

    //Earth 6.5
    let earth = new Moon(new THREE.Vector3(0, 0, 3), new THREE.Vector3(0.003, 0, 0), 0.32, globes, moons, scene);
    moons.push(earth);
    //earth.sphere.material.map = THREE.ImageUtils.loadTexture('assets/Earth.jpg');
    //normalTexture = textureLoader.load('assets/Earth.jpg');
    //mercury.sphere.material.normalMap = normalTexture;
    //Mars 3.2
    moons.push(new Moon(new THREE.Vector3(0, 0, 3.3), new THREE.Vector3(0.002, 0, 0), 0.15, globes, moons, scene));

    //Jupiter 70
    moons.push(new Moon(new THREE.Vector3(0, 0, 5), new THREE.Vector3(0.005, 0, 0), 1.5, globes, moons, scene));

    //Saturn 58
    moons.push(new Moon(new THREE.Vector3(0, 0, 5.7), new THREE.Vector3(0.004, 0, 0), 1, globes, moons, scene));

    //Uranus 25
    moons.push(new Moon(new THREE.Vector3(0, 0, 6.5), new THREE.Vector3(0.003, 0, 0), 0.7, globes, moons, scene));

    //Nepture 24
    moons.push(new Moon(new THREE.Vector3(0, 0, 7), new THREE.Vector3(0.003, 0, 0), 0.65, globes, moons, scene));

    setTimeout(()=>{
        for (let index = 0; index < 3000; index++) {
            moons.forEach(moon => {
                if (!moon.update()) {
                    moons.splice(moons.indexOf(moon), 1);
                    scene.remove(moon.sphere);
                    scene.remove(moon.line);
                }
            });
        }
        moons.forEach(moon => {
            console.log(moon.position, moon.velocity);
        });
    },5)
}

//init Scene
let controls, gui, particles;
function init() {
    globes = [];

    //Gui
    gui = new GUI();
    let folder = gui.addFolder("Sandbox");
    folder.add(params, 'globe').name("Globe Spawner");
    folder.add(params, 'size', 0.5, 10 ).name("Size");
    folder.add(params, 'sandboxMode').name("Sandbox mode");
    gui.add(params, 'reset').name("Reset Solar System");
    gui.domElement.style.position = 'absolute';
    gui.domElement.style.top = '100px';
    gui.domElement.style.right = '-2%';

    //Orbit controls
    controls = new OrbitControls(camera, renderer.domElement);
    controls.minDistance = 2;
    controls.maxDistance = 20;

    //particle system
    let particlesGeometry = new THREE.BufferGeometry;
    let particleCount = 1_000;
    let posArray = new Float32Array(particleCount * 3);
    for (let i = 0; i < particleCount; i++) {
        posArray[i] = Math.random() * 30 - 15;
    }
    let material = new THREE.PointsMaterial({ size: 0.005 });
    particlesGeometry.setAttribute('position', new THREE.BufferAttribute(posArray, 3));
    particles = new THREE.Points(particlesGeometry, material);
    scene.add(particles);

    //init globes
    let sun = new Globe(new THREE.Vector3(0, 0, 0), 10, scene, 0);
    sun.sphere.material.emissive = new THREE.Color(0xFF4411);;
    globes = [sun];
    globes.forEach(globe => {
        globe.update();
    });
    sun.sphere.material.normalMap = normalTexture;

    //init point lights
    setTimeout(sunPoints, 5);
    function sunPoints() {
        for (let teta = 0; teta < 2 * Math.PI; teta += 3.14 / 5) {
            for (let gamma = 0; gamma < Math.PI; gamma += 3.14 / 5) {
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

    //init solar system
    initSolarSystem();
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
function future(clone, x, y) {
    let position = clone.position.clone();
    let velocity = clone.velocity.clone();
    for (let i = 0; i < 1001; i++) {
        if (mouse.x != x || mouse.y != y)
            break;
        if(!clone.update())
            break;
    }
    clone.sphere.position.x = position.x;
    clone.sphere.position.y = position.y;
    clone.sphere.position.z = position.z;
    clone.points = [];
    clone.position = position;
    clone.velocity = velocity;
}

function onMouseMove(event) {
    mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
    mouse.y = - (event.clientY / window.innerHeight) * 2 + 1;
}
renderer.domElement.addEventListener('mousemove', onMouseMove, false);

//On click event listener
let camTarget = globes[0].position;
window.addEventListener('click', onClick, false);

let created = false;
let moon = null;
function onClick(event) {
    if (!sandboxMode) {
        raycaster.setFromCamera(mouse, camera);
        let intersects = raycaster.intersectObjects(meshs);
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
    else {
        // raycaster.setFromCamera(mouse, camera);
        // let intersects = raycaster.intersectObjects(meshs);
        // try {
        //     //intersects[0].object.position;
        //     // console.log(globes[0].position.distanceTo(intersects[0].object.position), mouse.length(), 
        //     // globes[0].position.distanceTo(intersects[0].object.position)/mouse.length()); 
        // } catch (error) {
        // }
    }

}

//On keydown event listener
document.addEventListener("keydown", onDocumentKeyDown, false);
function onDocumentKeyDown(event) {
    let keyCode = event.which;
    let direction = new THREE.Vector3();
    camera.getWorldDirection(direction).normalize();
    if (keyCode == 37) {
    } if ([38, 90].includes(keyCode)) {
        camera.position.add(direction.clone().multiplyScalar(0.1));
    } if ([40, 83].includes(keyCode)) {
        camera.position.add(direction.clone().negate().multiplyScalar(0.1));
    }
};

//mouse down
let mousedownID = -1;  //Global ID of mouse down interval
function mousedown(event) {
    if (mousedownID == -1)  //Prevent multimple loops!
        mousedownID = setInterval(whilemousedown, 20);
}

function mouseup(event) {
    if (mousedownID != -1) {  //Only stop if exists
        clearInterval(mousedownID);
        mousedownID = -1;
    }
    created = false;
    if (moon)
        moons.push(moon);
    moon = null;
}
function whilemousedown() {
    if (!created) {
        let pos = new THREE.Vector3(mouse.x * 12.46, 0, -mouse.y * 7.77);
        if (params.globe) {
            let globe = new Globe(pos, params.size, scene);
            globes.push(globe);
            globe.update();
        }
        else {
            moon = new Moon(pos, new THREE.Vector3(0, 0, 0), params.size, globes, moons, scene);
            moon.update();
        }
        created = true;
    }
    else if (moon) {
        let mousePos = new THREE.Vector3(mouse.x * 12.46, 0, -mouse.y * 7.77);
        let moonPos = moon.position.clone();
        let dist = mousePos.distanceTo(moonPos);
        let velocity = moonPos.add(mousePos.negate());
        velocity.multiplyScalar(dist * 0.001);
        moon.velocity = velocity;
        future(moon, mouse.x, mouse.y);
    }
}
//Assign events
renderer.domElement.addEventListener("mousedown", mousedown);
renderer.domElement.addEventListener("mouseup", mouseup);


//sandbox Mode
function startSandboxMode() {
    if (sandboxMode) {
        camera.position.set(0, 3, 10)
        sandboxMode = false;
        controls = new OrbitControls(camera, renderer.domElement);
        controls.minDistance = 2;
        controls.maxDistance = 20;
    }
    else {
        sandboxMode = true;
        camera.lookAt(globes[0].position);
        camera.position.set(0, 10, 0);
        controls.enableRotate = false;
        controls.enableZoom = false;
        controls.dispose();
    }
    controls.update();
}
//Main loop
let animate = function () {
    camera.lookAt(camTarget);
    globes.forEach(globe => {
        globe.sphere.rotation.y += 0.005;
    });
    moons.forEach(moon => {
        if (!moon.update()) {
            moons.splice(moons.indexOf(moon), 1);
            scene.remove(moon.sphere);
            scene.remove(moon.line);
        }
    });
    particles.rotation.y += 0.0005;
    renderer.render(scene, camera);
    requestAnimationFrame(animate);
};
animate();
