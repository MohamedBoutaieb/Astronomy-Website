textureLoader = new THREE.TextureLoader();
normalTexture = textureLoader.load('../images/sun_texture.jpg');
class Globe {
    constructor(position, mass, scene) {
        this.position = position;
        this.mass = mass;
        var geometry = new THREE.SphereGeometry(mass / 10, 50, 50);
        var material = new THREE.MeshStandardMaterial({ color: 0xFF4411 });
        material.roughness = 1;
        //material.normalMap = normalTexture;
        this.sphere = new THREE.Mesh(geometry, material);
        //this.sphere.position = this.position;
        scene.add(this.sphere);
    }
    update() {
        this.sphere.position.x = this.position.x;
        this.sphere.position.y = this.position.y;
        this.sphere.position.z = this.position.z;
    }
}
class Moon extends Globe {
    constructor(position, velocity, mass, globes, moons, scene) {
        super(position, mass, scene);
        this.acceleration = new THREE.Vector3(0,0,0);
        this.velocity = velocity;
        this.globes = globes;
        this.points = [];
        this.moons = moons;
        this.sphere.material = new THREE.MeshStandardMaterial({ color: 0xFFFFAA });
        //LineBasicMaterial
        var material = new THREE.LineBasicMaterial({ color: 0xAAAAAA });
        var geometry = new THREE.BufferGeometry().setFromPoints(this.points);
        this.line = new THREE.Line(geometry, material);
        scene.add(this.line);
    }
    update() {
        super.update();
        var outOfBounds = true;
        this.globes.forEach(globe => {
            if (this != globe) {
                this.acceleration.addVectors(globe.position, this.position.clone().negate());
                this.acceleration.multiplyScalar(1 / Math.pow(this.acceleration.length(), 3) * this.mass * globe.mass * 0.00001);
                this.velocity.add(this.acceleration);
                this.position.add(this.velocity);
            }
            //out of bounds
            if(this.position.clone().add(globe.position.clone().negate()).length() <= (globe.mass + this.mass)/10)
                outOfBounds = false;
        });

        //Orbit
        if (this.points.length > 1000)
            this.points.splice(0, 1);
        this.points.push(this.position.clone());
        this.line.geometry.setFromPoints(this.points);
        
        //out of bounds
        if(!outOfBounds)
            return false;
        return true;
    }
}