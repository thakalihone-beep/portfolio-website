const mount = document.getElementById('portfolio-world-canvas');

if (mount) {
	initializePortfolioWorld();
}

async function initializePortfolioWorld() {
	const THREE = await import('three');
	const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	const pageType = document.body.dataset.spatialPage || 'archive';
	const variants = {
		about: {
			geometry: () => new THREE.SphereGeometry(3.6, 64, 48),
			color: 0x547c72, emissive: 0x234c42, light: 0xff8545, rim: 0x57bdad,
			position: [8.5, 5, -2.5], cameraZ: 21, orbit: 5.2, tilt: 1.13
		},
		projects: {
			geometry: () => new THREE.IcosahedronGeometry(3.4, 1),
			color: 0x73503d, emissive: 0x3b1f12, light: 0xff782e, rim: 0xd6a275,
			position: [8.2, 4.5, -2.5], cameraZ: 21, orbit: 5.4, tilt: 0.72
		},
		skills: {
			geometry: () => new THREE.OctahedronGeometry(3.6, 0),
			color: 0x407d72, emissive: 0x123e36, light: 0x60dbbd, rim: 0xb6dbd4,
			position: [8.4, 4.6, -2.5], cameraZ: 21, orbit: 5.1, tilt: 1.28
		},
		journal: {
			geometry: () => new THREE.TorusKnotGeometry(2.45, 0.72, 144, 18, 2, 5),
			color: 0x8a5b39, emissive: 0x49240f, light: 0xffa45e, rim: 0xdfbc83,
			position: [8.1, 4.8, -2.5], cameraZ: 22, orbit: 5.8, tilt: 0.92
		},
		contact: {
			geometry: () => new THREE.TorusGeometry(2.8, 0.78, 24, 96),
			color: 0x8c7438, emissive: 0x44340e, light: 0xffd166, rim: 0x9bd3bd,
			position: [8.2, 4.4, -2.5], cameraZ: 21, orbit: 6.2, tilt: 1.46
		},
		article: {
			geometry: () => new THREE.SphereGeometry(3.2, 48, 36),
			color: 0x466e77, emissive: 0x142d36, light: 0xff9763, rim: 0x82c5d0,
			position: [8.5, 4.8, -2.5], cameraZ: 22, orbit: 5.7, tilt: 1.08
		}
	};
	const variant = variants[pageType] || variants.about;
	const scene = new THREE.Scene();
	const camera = new THREE.PerspectiveCamera(44, 1, 0.1, 100);
	const renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true, powerPreference: 'low-power' });
	const world = new THREE.Group();
	const planet = new THREE.Group();
	const pointer = new THREE.Vector2();
	const targetPointer = new THREE.Vector2();
	const starCount = window.matchMedia('(max-width: 700px)').matches ? 420 : 900;
	const starPositions = new Float32Array(starCount * 3);
	let previousFrameTime = performance.now();
	let elapsedTime = 0;
	let animationFrame = 0;
	let destroyed = false;

	camera.position.set(0, 0, 21);
	renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 1.6));
	renderer.setSize(window.innerWidth, window.innerHeight);
	renderer.outputColorSpace = THREE.SRGBColorSpace;
	mount.appendChild(renderer.domElement);
	scene.add(world);
	world.add(planet);

	scene.add(new THREE.AmbientLight(0x9fb5b0, 1.6));

	const keyLight = new THREE.PointLight(variant.light, 140, 50, 2);
	keyLight.position.set(-8, 6, 10);
	scene.add(keyLight);

	const rimLight = new THREE.PointLight(variant.rim, 95, 40, 2);
	rimLight.position.set(8, -4, 4);
	scene.add(rimLight);

	const planetBody = new THREE.Mesh(
		variant.geometry(),
		new THREE.MeshStandardMaterial({
			color: variant.color,
			metalness: 0.38,
			roughness: 0.46,
			emissive: variant.emissive,
			emissiveIntensity: 1.18
		})
	);
	planet.add(planetBody);

	const planetGrid = new THREE.Mesh(
		variant.geometry(),
		new THREE.MeshBasicMaterial({
			color: variant.rim,
			wireframe: true,
			transparent: true,
			opacity: 0.22,
			depthWrite: false
		})
	);
	planet.add(planetGrid);

	const atmosphere = new THREE.Mesh(
		new THREE.SphereGeometry(3.78, 48, 32),
		new THREE.MeshBasicMaterial({
			color: 0x75c8b2,
			transparent: true,
			opacity: 0.2,
			side: THREE.BackSide,
			depthWrite: false
		})
	);
	planet.add(atmosphere);

	const orbitMaterials = [
		new THREE.MeshBasicMaterial({ color: 0xff9258, transparent: true, opacity: 0.92 }),
		new THREE.MeshBasicMaterial({ color: 0xa3d1c6, transparent: true, opacity: 0.48 })
	];

	const orbit = new THREE.Mesh(new THREE.TorusGeometry(variant.orbit, 0.018, 8, 160), orbitMaterials[0]);
	orbit.rotation.set(variant.tilt, 0.1, -0.22);
	planet.add(orbit);

	const orbitFar = new THREE.Mesh(new THREE.TorusGeometry(6.2, 0.012, 8, 160), orbitMaterials[1]);
	orbitFar.rotation.set(0.62, 0.4, 0.38);
	planet.add(orbitFar);

	const moon = new THREE.Mesh(
		new THREE.SphereGeometry(0.34, 24, 18),
		new THREE.MeshStandardMaterial({ color: 0xc7a17c, metalness: 0.46, roughness: 0.62 })
	);
	planet.add(moon);

	for (let index = 0; index < starCount; index++) {
		const offset = index * 3;
		starPositions[offset] = (Math.random() - 0.5) * 54;
		starPositions[offset + 1] = (Math.random() - 0.5) * 34;
		starPositions[offset + 2] = -8 - Math.random() * 42;
	}

	const starGeometry = new THREE.BufferGeometry();
	starGeometry.setAttribute('position', new THREE.BufferAttribute(starPositions, 3));
	const stars = new THREE.Points(
		starGeometry,
		new THREE.PointsMaterial({ color: variant.rim, size: 0.045, transparent: true, opacity: 0.72, sizeAttenuation: true })
	);
	scene.add(stars);

	function resize() {
		const width = Math.max(1, window.innerWidth);
		const height = Math.max(1, window.innerHeight);
		const mobile = width <= 700;

		camera.aspect = width / height;
		camera.position.z = variant.cameraZ;
		camera.updateProjectionMatrix();
		renderer.setSize(width, height);
		planet.position.set(mobile ? 1.6 : variant.position[0], mobile ? -2.5 : variant.position[1], variant.position[2]);
	}

	function onPointerMove(event) {
		if (event.pointerType === 'touch') return;
		targetPointer.set(
			(event.clientX / window.innerWidth) * 2 - 1,
			1 - (event.clientY / window.innerHeight) * 2
		);
	}

	function render() {
		if (destroyed) return;

		const frameTime = performance.now();
		const delta = Math.min((frameTime - previousFrameTime) / 1000, 0.05);
		previousFrameTime = frameTime;
		elapsedTime += delta;
		const time = elapsedTime;
		pointer.lerp(targetPointer, 1 - Math.exp(-delta * 2.2));

		if (!reducedMotion) {
			planet.rotation.y = time * 0.035 + pointer.x * 0.08;
			planet.rotation.x = Math.sin(time * 0.12) * 0.035 - pointer.y * 0.035;
			orbit.rotation.z = Math.sin(time * 0.08) * 0.035;
			moon.position.set(Math.cos(time * 0.22) * 5.2, Math.sin(time * 0.22) * 1.8, Math.sin(time * 0.22) * 2.2);
			stars.rotation.y = time * 0.002;
		}

		renderer.render(scene, camera);
		animationFrame = window.requestAnimationFrame(render);
	}

	function cleanup() {
		destroyed = true;
		window.cancelAnimationFrame(animationFrame);
		window.removeEventListener('resize', resize);
		window.removeEventListener('pointermove', onPointerMove);
		window.removeEventListener('pagehide', cleanup);
		scene.traverse(object => {
			object.geometry?.dispose();
			if (Array.isArray(object.material)) object.material.forEach(material => material.dispose());
			else object.material?.dispose();
		});
		renderer.dispose();
	}

	resize();
	window.addEventListener('resize', resize, { passive: true });
	window.addEventListener('pointermove', onPointerMove, { passive: true });
	window.addEventListener('pagehide', cleanup, { once: true });
	render();
}
