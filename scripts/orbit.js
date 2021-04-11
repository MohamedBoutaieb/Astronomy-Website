var scene = new THREE.Scene();
var camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight);
camera.position.z = 10;

var renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
renderer.setSize(window.innerWidth, window.innerHeight);
document.body.append(renderer.domElement);

//Adaptive Resolution
window.addEventListener("resize", onResize);
function onResize(event) {
    renderer.setSize(window.innerWidth, window.innerHeight);
    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();
}

//init Scene
init = () => {
    //init light
    const directionalLight = new THREE.DirectionalLight(0xfffff1, 1);
    directionalLight.position.set(2, 4, 4);
    scene.add(directionalLight);

    //init globes
    sun = new Globe(new THREE.Vector3(0, 0, 0), 10, scene, 0);
    sun.sphere.material.emissive = new THREE.Color( 0xFF4411 );;
    globes = [sun];
    globes.forEach(globe => {
        globe.update();
    });
    //init point lights
    let pointlight = new THREE.PointLight(0xFFFFCC, 1);
    pointlight.position.set(sun.position);
    scene.add(pointlight)
    //init moons
    moons = [];
    //Mercury 2.5
    var mercury = new Moon(new THREE.Vector3(0, 0, 2), new THREE.Vector3(0.002, 0, 0), 0.1, globes, scene);
    moons.push(mercury);
    //normalTexture = textureLoader.load('assets/Mercury.png');
    //mercury.sphere.material.normalMap = normalTexture;
    //Venus 3 * 2.5
    venus = new Moon(new THREE.Vector3(0, 0, 2.5), new THREE.Vector3(0.003, 0, 0), 0.3, globes, scene);
    moons.push(venus);
    //normalTexture = textureLoader.load('assets/venus.png');
    //mercury.sphere.material.normalMap = normalTexture;
    //Earth 6.5
    earth = new Moon(new THREE.Vector3(0, 0, 3), new THREE.Vector3(0.003, 0, 0), 0.32, globes, scene);
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

//Raycaster
const raycaster = new THREE.Raycaster();
const mouse = new THREE.Vector2();

//onMouseMove
function onMouseMove(event) {
    mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
    mouse.y = - (event.clientY / window.innerHeight) * 2 + 1;
    camera.position.x = mouse.x * 10;
    camera.position.y = mouse.y * 10;
}
window.addEventListener('mousemove', onMouseMove, false);

const meshs = scene.children.filter(object => {try {
    return object.geometry.type == "SphereGeometry";
} catch (error) {
    return false;
}});

var scroll = false;
var lastScroll = 0;
//On Scroll
window.addEventListener('scroll', event => {
    camera.position.y = window.scrollY * 0.001;
    camera.lookAt(globes[0].position);
    // if(! scroll){
    //     camera.position.y = window.scrollY * 0.001;
    //     camera.lookAt(globes[0].position);
    // }
    // else{
    //     camera.position.z += (window.scrollY - lastScroll) * 0.001;
    // }
    lastScroll = window.scrollY;
})

//On click
camTarget = globes[0].position;
window.addEventListener('click', onClick, false);
function onClick(event){
    if(intersects.length == 0){
        camTarget = globes[0].position;
        scroll = false;
    }
    else{
        camTarget = intersects[0].object.position;
        camera.lookAt(camTarget);
        scroll = true;
    }
    
}
//On keydown
document.addEventListener("keydown", onDocumentKeyDown, false);
function onDocumentKeyDown(event) {
    var keyCode = event.which;
    direction = new THREE.Vector3();
    camera.getWorldDirection(direction).normalize();
    // up

    if (keyCode == 37) {
        
    } if ([38, 90].includes(keyCode)) {
        camera.position.add(direction.clone().multiplyScalar(0.1));
    } if ([39, 83].includes(keyCode)) {
        camera.position.add(direction.clone().negate().multiplyScalar(0.1));
    } if (keyCode == 40) {
    }
};



var animate = function () {
    //Mouse Intersects
    // raycaster.setFromCamera(mouse, camera);
    // intersects = raycaster.intersectObjects(meshs);
    // intersects.forEach((globe) => {
    //     globe.object.rotation.x += 0.005;
    // });
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
