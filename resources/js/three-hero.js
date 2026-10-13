
import * as THREE from 'three';

const container = document.querySelector('#three-hero');

if (container) {
    const scene = new THREE.Scene();

    const camera = new THREE.PerspectiveCamera(38, 1, 0.1, 100);
    camera.position.set(0, 0, 8);

    const renderer = new THREE.WebGLRenderer({
        alpha: true,
        antialias: true,
        powerPreference: 'high-performance',
    });

    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 1.75));
    renderer.outputColorSpace = THREE.SRGBColorSpace;
    renderer.setSize(1, 1);
    container.appendChild(renderer.domElement);

    const artwork = new THREE.Group();
    scene.add(artwork);

    // Core: procedural animated material.
    const coreGeometry = new THREE.IcosahedronGeometry(1.05, 5);

    const coreMaterial = new THREE.ShaderMaterial({
        uniforms: {
            uTime: { value: 0 },
            uColorA: { value: new THREE.Color('#7c2d12') },
            uColorB: { value: new THREE.Color('#f97316') },
            uColorC: { value: new THREE.Color('#fed7aa') },
        },
        vertexShader: `
            varying vec3 vNormal;
            varying vec3 vPosition;

            void main() {
                vNormal = normalize(normalMatrix * normal);
                vPosition = position;

                vec3 transformed = position;
                float pulse = sin(position.y * 5.0 + position.x * 3.0) * 0.025;
                transformed += normal * pulse;

                gl_Position = projectionMatrix * modelViewMatrix * vec4(transformed, 1.0);
            }
        `,
        fragmentShader: `
            uniform float uTime;
            uniform vec3 uColorA;
            uniform vec3 uColorB;
            uniform vec3 uColorC;

            varying vec3 vNormal;
            varying vec3 vPosition;

            void main() {
                float light = max(dot(normalize(vNormal), normalize(vec3(-0.5, 0.7, 1.0))), 0.0);
                float bands = sin(vPosition.y * 7.0 + vPosition.x * 5.0 + uTime * 0.65);
                float mixValue = smoothstep(-0.65, 0.85, bands);

                vec3 color = mix(uColorA, uColorB, mixValue);
                color = mix(color, uColorC, pow(light, 5.0) * 0.75);
                color *= 0.55 + light * 0.8;

                float fresnel = pow(1.0 - abs(dot(normalize(vNormal), normalize(vec3(0.0, 0.0, 1.0)))), 2.0);
                color += uColorB * fresnel * 0.45;

                gl_FragColor = vec4(color, 0.96);
                #include <tonemapping_fragment>
                #include <colorspace_fragment>
            }
        `,
    });

    const core = new THREE.Mesh(coreGeometry, coreMaterial);
    artwork.add(core);

    // Dense triangular shell.
    const shellGeometry = new THREE.IcosahedronGeometry(1.55, 3);
    const shellMaterial = new THREE.MeshBasicMaterial({
        color: '#fb923c',
        wireframe: true,
        transparent: true,
        opacity: 0.48,
    });

    const shell = new THREE.Mesh(shellGeometry, shellMaterial);
    artwork.add(shell);

    // Secondary geometric layer.
    const innerGeometry = new THREE.IcosahedronGeometry(1.25, 2);
    const innerMaterial = new THREE.MeshBasicMaterial({
        color: '#fdba74',
        wireframe: true,
        transparent: true,
        opacity: 0.2,
    });

    const innerShell = new THREE.Mesh(innerGeometry, innerMaterial);
    artwork.add(innerShell);

    // Orbit rings with different inclinations.
    const rings = [];

    for (let i = 0; i < 3; i++) {
        const ringGeometry = new THREE.TorusGeometry(
            1.9 + i * 0.13,
            0.0035,
            6,
            180
        );

        const ringMaterial = new THREE.MeshBasicMaterial({
            color: i === 1 ? '#fb923c' : '#c2410c',
            transparent: true,
            opacity: 0.58 - i * 0.12,
        });

        const ring = new THREE.Mesh(ringGeometry, ringMaterial);

        ring.rotation.x = [1.08, 0.35, 1.4][i];
        ring.rotation.y = [0.2, 1.0, -0.6][i];
        ring.rotation.z = i * 0.6;

        artwork.add(ring);
        rings.push(ring);
    }

    // Floating point field.
    const count = 950;
    const positions = new Float32Array(count * 3);
    const sizes = new Float32Array(count);

    for (let i = 0; i < count; i++) {
        const i3 = i * 3;

        positions[i3] = (Math.random() - 0.5) * 7;
        positions[i3 + 1] = (Math.random() - 0.5) * 7;
        positions[i3 + 2] = (Math.random() - 0.5) * 4;

        sizes[i] = Math.random();
    }

    const particleGeometry = new THREE.BufferGeometry();
    particleGeometry.setAttribute(
        'position',
        new THREE.BufferAttribute(positions, 3)
    );

    const particleMaterial = new THREE.PointsMaterial({
        color: '#fb923c',
        size: 0.018,
        transparent: true,
        opacity: 0.72,
        depthWrite: false,
        sizeAttenuation: true,
    });

    const particles = new THREE.Points(particleGeometry, particleMaterial);
    scene.add(particles);

    // A few brighter orbiting points.
    const satellites = [];

    for (let i = 0; i < 5; i++) {
        const geometry = new THREE.SphereGeometry(0.035 + (i % 2) * 0.018, 12, 12);
        const material = new THREE.MeshBasicMaterial({
            color: i % 2 === 0 ? '#fed7aa' : '#f97316',
        });

        const satellite = new THREE.Mesh(geometry, material);
        artwork.add(satellite);
        satellites.push(satellite);
    }

    // Mouse parallax.
    let pointerX = 0;
    let pointerY = 0;
    let smoothX = 0;
    let smoothY = 0;

    container.addEventListener('pointermove', (event) => {
        const rect = container.getBoundingClientRect();

        pointerX = ((event.clientX - rect.left) / rect.width - 0.5) * 0.8;
        pointerY = ((event.clientY - rect.top) / rect.height - 0.5) * 0.65;
    });

    container.addEventListener('pointerleave', () => {
        pointerX = 0;
        pointerY = 0;
    });

    function resize() {
        const width = container.clientWidth;
        const height = container.clientHeight;

        if (!width || !height) return;

        camera.aspect = width / height;
        camera.updateProjectionMatrix();
        renderer.setSize(width, height);
    }

    const resizeObserver = new ResizeObserver(resize);
    resizeObserver.observe(container);

    const reducedMotion = window.matchMedia(
        '(prefers-reduced-motion: reduce)'
    ).matches;

    const clock = new THREE.Clock();
    let animationId = null;
    let visible = true;
    let disposed = false;

    function render() {
        if (disposed || !visible) return;

        animationId = requestAnimationFrame(render);

        const t = clock.getElapsedTime();

        smoothX += (pointerX - smoothX) * 0.035;
        smoothY += (pointerY - smoothY) * 0.035;

        if (!reducedMotion) {
            artwork.rotation.y = t * 0.12 + smoothX;
            artwork.rotation.x = Math.sin(t * 0.18) * 0.12 + smoothY;
            artwork.position.y = Math.sin(t * 0.65) * 0.06;

            shell.rotation.y = -t * 0.045;
            shell.rotation.x = t * 0.035;

            innerShell.rotation.y = t * 0.08;
            innerShell.rotation.z = -t * 0.05;

            rings.forEach((ring, i) => {
                ring.rotation.z += (i % 2 === 0 ? 1 : -1) * 0.0015;
            });

            particles.rotation.y = t * 0.012;
            particles.rotation.x = Math.sin(t * 0.15) * 0.025;

            satellites.forEach((satellite, i) => {
                const angle = t * (0.35 + i * 0.035) + i * (Math.PI * 2 / 5);
                const radius = 2.0 + (i % 2) * 0.25;

                satellite.position.set(
                    Math.cos(angle) * radius,
                    Math.sin(angle * 1.15) * radius * 0.7,
                    Math.sin(angle) * radius * 0.65
                );
            });
        }

        coreMaterial.uniforms.uTime.value = t;

        camera.position.x += (smoothX * 0.45 - camera.position.x) * 0.02;
        camera.position.y += (-smoothY * 0.3 - camera.position.y) * 0.02;
        camera.lookAt(0, 0, 0);

        renderer.render(scene, camera);
    }

    function start() {
        if (disposed || !visible || animationId !== null) return;
        render();
    }

    const visibilityObserver = new IntersectionObserver(([entry]) => {
        visible = entry.isIntersecting;

        if (visible) {
            start();
        } else if (animationId !== null) {
            cancelAnimationFrame(animationId);
            animationId = null;
        }
    });

    visibilityObserver.observe(container);

    resize();
    start();

    window.addEventListener('pagehide', () => {
        disposed = true;

        if (animationId !== null) {
            cancelAnimationFrame(animationId);
        }

        resizeObserver.disconnect();
        visibilityObserver.disconnect();

        coreGeometry.dispose();
        coreMaterial.dispose();
        shellGeometry.dispose();
        shellMaterial.dispose();
        innerGeometry.dispose();
        innerMaterial.dispose();
        particleGeometry.dispose();
        particleMaterial.dispose();

        rings.forEach((ring) => {
            ring.geometry.dispose();
            ring.material.dispose();
        });

        satellites.forEach((satellite) => {
            satellite.geometry.dispose();
            satellite.material.dispose();
        });

        renderer.dispose();
    }, { once: true });
}
