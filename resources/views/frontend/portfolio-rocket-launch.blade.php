@extends('layouts.app')

@section('content')

{{--
    IMPORT MAP
    Needed so three.js addons (EffectComposer, bloom, etc.) can resolve `three`.
    If your layout loads a module script (e.g. @vite) in <head> BEFORE this point,
    move this <script type="importmap"> block into the layout <head>, above @vite.
--}}
<script type="importmap">
{
    "imports": {
        "three": "https://cdn.jsdelivr.net/npm/three@0.180.0/build/three.module.js",
        "three/addons/": "https://cdn.jsdelivr.net/npm/three@0.180.0/examples/jsm/"
    }
}
</script>

<section id="computational-cathedral" aria-label="Immersive 3D portfolio">

    <div id="cathedral-canvas"></div>

    <div class="cathedral-vignette"></div>
    <div class="cathedral-grain"></div>

    <!-- Interface: integrated into the 3D environment -->

    <header class="cathedral-header">
        <a href="#computational-cathedral" class="cathedral-brand">
            <span class="brand-symbol">R<span>/</span>G</span>
            <span class="brand-caption">INDEPENDENT DIGITAL SYSTEMS</span>
        </a>

        <div class="system-status">
            <span class="status-light"></span>
            <span>WORLD ONLINE</span>
            <span class="status-divider">/</span>
            <span id="scene-clock">00:00:00</span>
        </div>
    </header>

    <div class="cathedral-index">
        <span class="index-label">SPATIAL INDEX</span>

        <button class="world-marker is-active" data-view="origin">
            <span>01</span> ORIGIN
        </button>

        <button class="world-marker" data-view="architecture">
            <span>02</span> ARCHITECTURE
        </button>

        <button class="world-marker" data-view="network">
            <span>03</span> NETWORK
        </button>

        <button class="world-marker" data-view="horizon">
            <span>04</span> HORIZON
        </button>
    </div>

    <main class="cathedral-intro">
        <div class="intro-overline">
            <span class="overline-line"></span>
            <span>ROSHAN GAUCHAN</span>
            <span class="overline-coordinate">27°42' N / 85°19' E</span>
        </div>

        <h1>
            <span>BUILD</span>
            <span class="title-second">BEYOND <i>THE</i></span>
            <span class="title-third">VISIBLE<span class="title-period">.</span></span>
        </h1>

        <p class="intro-description">
            Engineering digital worlds at the intersection of
            software, intelligent systems, and imagination.
        </p>

        <div class="floating-identity" aria-label="Core disciplines">
            <span>WEB SYSTEMS</span>
            <span>AI PRODUCTS</span>
            <span>CREATIVE DEV</span>
        </div>

        <div class="intro-bottom">
            <button id="enter-world" class="enter-world">
                <span class="enter-icon">↗</span>
                <span>EXPLORE THE WORLD</span>
                <span class="enter-line"></span>
            </button>

            <span class="intro-coordinate">SYSTEM 001 — RG</span>
        </div>
    </main>

    <aside class="cathedral-right">
        <div class="vertical-label">A WORLD UNDER CONSTRUCTION</div>

        <div class="right-orbit">
            <span class="orbit-number">001</span>
            <span class="orbit-cross">+</span>
        </div>

        <span class="right-caption">MOVE / OBSERVE / DISCOVER</span>
    </aside>

    <div class="cathedral-bottom">
        <div class="bottom-left">
            <span class="bottom-dot"></span>
            <span>PROCEDURAL ENVIRONMENT</span>
            <span class="bottom-separator hud-extra">/</span>
            <span id="hud-coord" class="hud-extra">X +00.0 Z +00.0</span>
        </div>

        <div class="bottom-center" id="interaction-hint">
            MOVE TO DISTORT <span>·</span> DRAG TO ORBIT <span>·</span> CLICK THE SPIRE TO LAUNCH <span>·</span> KEYS 1–4
        </div>

        <div class="bottom-right">
            <span>REAL-TIME 3D</span>
            <span class="bottom-separator">/</span>
            <span>WEBGL</span>
            <span class="bottom-separator hud-extra">/</span>
            <span id="hud-fps" class="hud-extra">-- FPS</span>
        </div>
    </div>

    <!-- Custom cursor (fine pointers only) -->
    <div class="cathedral-cursor" aria-hidden="true">
        <span class="cursor-ring"></span>
        <span class="cursor-dot"></span>
        <span class="cursor-label"></span>
    </div>

    <div id="launch-readout" aria-live="polite">
        <span id="lr-phase">READY</span>
        <span id="lr-count">CLICK THE SPIRE TO LAUNCH</span>
        <span id="lr-data"><span id="lr-alt">ALT 000 M</span><span id="lr-vel">VEL 000 M/S</span></span>
    </div>

    <div id="cathedral-loader" aria-live="polite">
        <div class="loader-content">
            <span class="loader-mark">RG<span>.</span></span>
            <span class="loader-label">CONSTRUCTING THE UNKNOWN</span>
            <div class="loader-track"><div id="loader-progress"></div></div>
            <span id="loader-percent">INITIALIZING 00%</span>
        </div>
    </div>

</section>

<style>
    #computational-cathedral {
        --void: #050606;
        --white: #eeeae2;
        --muted: rgba(238, 234, 226, .47);
        --orange: #ff782e;
        --line: rgba(238, 234, 226, .14);
        --px: 0;
        --py: 0;

        position: relative;
        isolation: isolate;
        width: 100%;
        height: 100svh;
        min-height: 620px;
        overflow: hidden;
        background: var(--void);
        color: var(--white);
        font-family: inherit;
        user-select: none;
        -webkit-user-select: none;
    }

    #cathedral-canvas {
        position: absolute;
        inset: 0;
        z-index: 0;
        overflow: hidden;
        cursor: grab;
        touch-action: pan-y;
    }

    #cathedral-canvas:active {
        cursor: grabbing;
    }

    @media (pointer: fine) {
        #cathedral-canvas,
        #cathedral-canvas:active {
            cursor: none;
        }
    }

    #cathedral-canvas canvas {
        display: block;
        width: 100%;
        height: 100%;
        outline: none;
    }

    .cathedral-vignette,
    .cathedral-grain {
        position: absolute;
        inset: 0;
        pointer-events: none;
    }

    .cathedral-vignette {
        z-index: 1;
        background:
            linear-gradient(90deg,
                rgba(3, 4, 4, .88) 0%,
                rgba(3, 4, 4, .65) 24%,
                rgba(3, 4, 4, .05) 58%,
                rgba(3, 4, 4, .25) 100%),
            linear-gradient(0deg,
                rgba(3, 4, 4, .7),
                transparent 23%,
                transparent 75%,
                rgba(3, 4, 4, .3));
    }

    .cathedral-grain {
        z-index: 2;
        opacity: .09;
        background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 180 180' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.88' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='.25'/%3E%3C/svg%3E");
    }

    .cathedral-header,
    .cathedral-index,
    .cathedral-intro,
    .cathedral-right,
    .cathedral-bottom {
        position: absolute;
        z-index: 4;
        /* Let the 3D canvas receive pointer input underneath the UI layers. */
        pointer-events: none;
    }

    .cathedral-header a,
    .cathedral-index button,
    .enter-world {
        pointer-events: auto;
    }

    .cathedral-header {
        top: 0;
        left: 0;
        right: 0;
        height: 86px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 clamp(20px, 4vw, 64px);
        border-bottom: 1px solid rgba(255,255,255,.08);
    }

    .cathedral-brand {
        display: flex;
        align-items: center;
        gap: 15px;
        color: var(--white);
        text-decoration: none;
    }

    .brand-symbol {
        font-size: 25px;
        font-weight: 800;
        letter-spacing: -.09em;
    }

    .brand-symbol span {
        color: var(--orange);
        font-weight: 400;
    }

    .brand-caption,
    .system-status,
    .index-label,
    .world-marker,
    .intro-overline,
    .intro-coordinate,
    .enter-world,
    .vertical-label,
    .right-caption,
    .bottom-left,
    .bottom-center,
    .bottom-right,
    .loader-label,
    #loader-percent {
        font-size: 9px;
        font-weight: 500;
        letter-spacing: .19em;
    }

    .brand-caption {
        color: var(--muted);
        letter-spacing: .17em;
    }

    .system-status {
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--muted);
    }

    .status-light,
    .bottom-dot {
        width: 5px;
        height: 5px;
        display: inline-block;
        border-radius: 50%;
        background: var(--orange);
        box-shadow: 0 0 12px rgba(255,120,46,.8);
    }

    .status-divider {
        color: var(--orange);
    }

    .cathedral-index {
        right: clamp(20px, 4vw, 64px);
        top: 50%;
        transform: translateY(-45%);
        display: flex;
        flex-direction: column;
        gap: 0;
    }

    .index-label {
        color: var(--muted);
        margin-bottom: 25px;
    }

    .world-marker {
        display: flex;
        align-items: center;
        gap: 16px;
        min-width: 155px;
        padding: 15px 0;
        border: 0;
        border-bottom: 1px solid rgba(255,255,255,.1);
        background: transparent;
        color: rgba(238,234,226,.4);
        text-align: left;
        cursor: pointer;
        transition: color .3s ease, padding .3s ease, translate .25s ease;
    }

    .world-marker span {
        color: rgba(238,234,226,.3);
        font-size: 8px;
    }

    .world-marker::before {
        content: "";
        width: 0;
        height: 1px;
        background: var(--orange);
        transition: width .35s ease;
    }

    .world-marker:hover,
    .world-marker.is-active {
        color: var(--white);
    }

    .world-marker.is-active::before {
        width: 20px;
    }

    .world-marker.is-active span {
        color: var(--orange);
    }

    .world-marker:focus-visible,
    .enter-world:focus-visible,
    .cathedral-brand:focus-visible {
        outline: 1px solid var(--orange);
        outline-offset: 6px;
    }

    .cathedral-intro {
        left: clamp(22px, 8.3vw, 130px);
        top: 50%;
        width: min(650px, 63%);
        transform: translateY(-40%);
        opacity: 0;
    }

    /* Pointer-driven text parallax (variables updated from the render loop). */
    .cathedral-intro h1 {
        translate: calc(var(--px) * -14px) calc(var(--py) * 8px);
    }

    .intro-description {
        translate: calc(var(--px) * -6px) calc(var(--py) * 4px);
    }

    .cathedral-right {
        translate: calc(var(--px) * 10px) calc(var(--py) * -6px);
    }

    .intro-overline {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        color: var(--orange);
        margin-bottom: 28px;
    }

    .overline-line {
        width: 27px;
        height: 1px;
        background: var(--orange);
    }

    .overline-coordinate {
        color: rgba(238,234,226,.38);
        margin-left: 12px;
        font-size: 8px;
    }

    .cathedral-intro h1 {
        padding: 0;
        margin: 0;
        font-size: clamp(58px, 8.2vw, 124px);
        font-weight: 650;
        line-height: .82;
        letter-spacing: -.085em;
        color: #eeeae2;
        text-transform: uppercase;
    }

    .cathedral-intro h1 > span {
        display: block;
        white-space: nowrap;
    }

    .cathedral-intro .title-second {
        margin-top: 12px;
        font-size: .75em;
        letter-spacing: -.075em;
    }

    .cathedral-intro .title-second i {
        font-size: .38em;
        font-style: normal;
        letter-spacing: .08em;
        vertical-align: middle;
        color: var(--orange);
    }

    .cathedral-intro .title-third {
        margin-top: 12px;
    }

    .title-period {
        color: var(--orange);
    }

    .intro-description {
        max-width: 360px;
        margin: 28px 0 0;
        color: rgba(238,234,226,.58);
        font-size: 13px;
        line-height: 1.9;
        letter-spacing: .015em;
    }

    .floating-identity {
        position: relative;
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 22px;
        translate: calc(var(--px) * -10px) calc(var(--py) * 6px);
    }

    .floating-identity span {
        position: relative;
        display: inline-flex;
        align-items: center;
        min-height: 28px;
        padding: 7px 12px;
        border: 1px solid rgba(255,255,255,.12);
        border-radius: 999px;
        background: rgba(13, 16, 18, 0.2);
        box-shadow: inset 0 0 0 1px rgba(255,255,255,0.03), 0 22px 30px rgba(0,0,0,0.18);
        color: rgba(255,255,255,0.8);
        font-size: 7px;
        font-weight: 600;
        letter-spacing: .22em;
        text-transform: uppercase;
        backdrop-filter: blur(10px);
    }

    .floating-identity span:nth-child(2) {
        transform: translateX(18px);
        border-color: rgba(255,120,46,.3);
    }

    .floating-identity span:nth-child(3) {
        transform: translateX(-14px);
    }

    .intro-bottom {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 28px;
        margin-top: 35px;
    }

    .enter-world {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 0;
        border: 0;
        background: transparent;
        color: var(--white);
        cursor: pointer;
        transition: translate .25s ease;
    }

    .enter-icon {
        display: grid;
        place-items: center;
        width: 35px;
        height: 35px;
        border: 1px solid rgba(255,120,46,.65);
        border-radius: 50%;
        color: var(--orange);
        font-size: 16px;
        transition: transform .3s ease, background .3s ease;
    }

    .enter-world:hover .enter-icon {
        transform: rotate(45deg);
        background: rgba(255,120,46,.1);
    }

    .enter-line {
        width: 32px;
        height: 1px;
        background: rgba(255,255,255,.28);
        transition: width .3s ease;
    }

    .enter-world:hover .enter-line {
        width: 52px;
    }

    .intro-coordinate {
        color: rgba(238,234,226,.4);
        font-size: 8px;
    }

    .cathedral-right {
        right: clamp(20px, 4vw, 64px);
        bottom: 118px;
        display: flex;
        align-items: center;
        flex-direction: column;
        gap: 24px;
    }

    .vertical-label {
        writing-mode: vertical-rl;
        color: rgba(238,234,226,.42);
        font-size: 8px;
    }

    .right-orbit {
        position: relative;
        width: 55px;
        height: 55px;
        display: grid;
        place-items: center;
        border: 1px solid rgba(255,255,255,.2);
        border-radius: 50%;
    }

    .right-orbit::before,
    .right-orbit::after {
        content: "";
        position: absolute;
        border: 1px solid rgba(255,120,46,.35);
        border-radius: 50%;
    }

    .right-orbit::before {
        inset: 8px -5px;
        transform: rotate(40deg);
    }

    .right-orbit::after {
        inset: -5px 8px;
        transform: rotate(-40deg);
    }

    .orbit-number {
        font-size: 8px;
        letter-spacing: .1em;
    }

    .orbit-cross {
        position: absolute;
        top: -10px;
        right: -6px;
        color: var(--orange);
    }

    .right-caption {
        writing-mode: vertical-rl;
        color: rgba(238,234,226,.32);
        font-size: 7px;
    }

    .cathedral-bottom {
        bottom: 0;
        left: 0;
        right: 0;
        min-height: 58px;
        padding: 12px clamp(20px, 4vw, 64px);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        border-top: 1px solid rgba(255,255,255,.09);
        color: rgba(238,234,226,.43);
    }

    .bottom-left,
    .bottom-center,
    .bottom-right {
        display: flex;
        align-items: center;
        gap: 11px;
        font-size: 8px;
    }

    .bottom-center {
        text-align: center;
    }

    .bottom-center span,
    .bottom-separator {
        color: var(--orange);
    }

    #hud-coord,
    #hud-fps {
        font-variant-numeric: tabular-nums;
        min-width: 11ch;
    }

    #hud-fps {
        min-width: 7ch;
    }

    /* ---------- Custom cursor ---------- */

    .cathedral-cursor {
        position: absolute;
        inset: 0;
        z-index: 6;
        pointer-events: none;
        opacity: 0;
        transition: opacity .3s ease;
    }

    .cathedral-cursor.is-visible {
        opacity: 1;
    }

    .cathedral-cursor.is-ui {
        opacity: 0;
    }

    .cursor-dot,
    .cursor-ring,
    .cursor-label {
        position: absolute;
        left: 0;
        top: 0;
        will-change: transform;
    }

    .cursor-dot {
        width: 5px;
        height: 5px;
        margin: -2.5px 0 0 -2.5px;
        border-radius: 50%;
        background: var(--orange);
        box-shadow: 0 0 14px rgba(255,120,46,.9);
    }

    .cursor-ring {
        width: 38px;
        height: 38px;
        margin: -19px 0 0 -19px;
        border: 1px solid rgba(255,120,46,.55);
        border-radius: 50%;
        transition: width .3s ease, height .3s ease, margin .3s ease,
                    border-color .3s ease, background .3s ease;
    }

    .cathedral-cursor.is-down .cursor-ring {
        width: 24px;
        height: 24px;
        margin: -12px 0 0 -12px;
        background: rgba(255,120,46,.14);
    }

    .cathedral-cursor.is-hot .cursor-ring {
        width: 68px;
        height: 68px;
        margin: -34px 0 0 -34px;
        border-color: rgba(255,160,90,.95);
        background: rgba(255,120,46,.08);
    }

    .cursor-label {
        margin: -5px 0 0 44px;
        font-size: 8px;
        letter-spacing: .19em;
        white-space: nowrap;
        color: var(--white);
        opacity: 0;
        transition: opacity .25s ease;
    }

    .cathedral-cursor.is-hot .cursor-label {
        opacity: 1;
    }

    @media (hover: none), (pointer: coarse) {
        .cathedral-cursor {
            display: none;
        }
    }

    #cathedral-loader {
        position: absolute;
        inset: 0;
        z-index: 20;
        display: grid;
        place-items: center;
        background: #050606;
    }

    .loader-content {
        display: flex;
        align-items: center;
        flex-direction: column;
        width: min(260px, 75%);
        gap: 20px;
    }

    .loader-mark {
        font-size: 52px;
        font-weight: 800;
        letter-spacing: -.1em;
    }

    .loader-mark span {
        color: var(--orange);
    }

    .loader-label,
    #loader-percent {
        font-size: 8px;
        color: var(--muted);
        text-align: center;
    }

    .loader-track {
        width: 100%;
        height: 1px;
        background: rgba(255,255,255,.14);
    }

    #loader-progress {
        height: 100%;
        width: 0;
        background: var(--orange);
    }

    @media (min-width: 1500px) {
        .cathedral-intro {
            left: 11vw;
        }
    }

    @media (max-width: 900px) {
        .cathedral-intro {
            width: 72%;
            left: 5vw;
        }

        .cathedral-intro h1 {
            font-size: clamp(56px, 10vw, 90px);
        }

        .cathedral-index {
            right: 20px;
        }

        .world-marker {
            min-width: 120px;
            font-size: 8px;
        }

        .cathedral-right {
            display: none;
        }

        .bottom-center {
            font-size: 7px;
        }
    }

    @media (max-width: 600px) {
        #computational-cathedral {
            min-height: 650px;
        }

        .cathedral-header {
            height: 68px;
            padding: 0 20px;
        }

        .brand-caption {
            display: none;
        }

        .system-status {
            font-size: 7px;
            gap: 6px;
        }

        .cathedral-index {
            top: 95px;
            right: 20px;
            transform: none;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: flex-end;
            width: 62%;
            gap: 5px 12px;
        }

        .index-label {
            display: none;
        }

        .world-marker {
            min-width: auto;
            gap: 5px;
            padding: 8px 0;
            border-bottom: 0;
            font-size: 7px;
        }

        .world-marker::before {
            display: none;
        }

        .cathedral-intro {
            top: 54%;
            left: 22px;
            width: calc(100% - 44px);
            transform: translateY(-35%);
        }

        .cathedral-intro h1 {
            font-size: clamp(48px, 12.8vw, 76px);
        }

        .cathedral-intro .title-second {
            font-size: .76em;
        }

        .intro-overline {
            font-size: 8px;
            margin-bottom: 24px;
        }

        .overline-coordinate {
            display: none;
        }

        .intro-description {
            max-width: 290px;
            font-size: 12px;
        }

        .floating-identity {
            gap: 8px;
            margin-top: 16px;
        }

        .floating-identity span {
            letter-spacing: .18em;
            font-size: 6.3px;
        }

        .floating-identity span:nth-child(2),
        .floating-identity span:nth-child(3) {
            transform: none;
        }

        .intro-bottom {
            gap: 18px;
            margin-top: 28px;
        }

        .intro-coordinate {
            display: none;
        }

        .cathedral-bottom {
            min-height: 54px;
            padding: 12px 18px;
        }

        .bottom-left,
        .bottom-right {
            font-size: 6px;
            gap: 5px;
        }

        .hud-extra {
            display: none;
        }

        .bottom-center {
            display: none;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        #computational-cathedral *,
        #computational-cathedral *::before,
        #computational-cathedral *::after {
            scroll-behavior: auto !important;
            transition-duration: .01ms !important;
        }

        .cathedral-intro h1,
        .intro-description,
        .cathedral-right {
            translate: none;
        }
    }
    .cathedral-intro { transition: filter .7s ease; }
    #computational-cathedral.is-launching .cathedral-intro { filter: opacity(.12); }
    #launch-readout {
        position: absolute; z-index: 4; pointer-events: none;
        left: clamp(22px, 8.3vw, 130px); bottom: 84px;
        display: grid; gap: 7px; font-size: 9px; font-weight: 500;
        letter-spacing: .19em; color: var(--muted);
    }
    #lr-phase { color: var(--orange); }
    #lr-count { color: var(--white); font-size: 11px; }
    #lr-data {
        display: flex; gap: 18px; opacity: 0; font-variant-numeric: tabular-nums;
        transition: opacity .4s ease;
    }
    #computational-cathedral.is-launching #lr-data { opacity: 1; }
    @media (max-width: 600px) {
        #launch-readout { left: 22px; bottom: 72px; }
        #lr-count { font-size: 9px; }
    }
</style>

<script type="module">
    import * as THREE from 'three';
    import { gsap } from 'https://cdn.jsdelivr.net/npm/gsap@3.13.0/+esm';
    import { EffectComposer } from 'three/addons/postprocessing/EffectComposer.js';
    import { RenderPass } from 'three/addons/postprocessing/RenderPass.js';
    import { UnrealBloomPass } from 'three/addons/postprocessing/UnrealBloomPass.js';
    import { ShaderPass } from 'three/addons/postprocessing/ShaderPass.js';
    import { OutputPass } from 'three/addons/postprocessing/OutputPass.js';
    import { RoomEnvironment } from 'three/addons/environments/RoomEnvironment.js';

    (() => {
        const root = document.getElementById('computational-cathedral');
        const mount = document.getElementById('cathedral-canvas');

        if (!root || !mount || root.dataset.initialized === 'true') return;
        root.dataset.initialized = 'true';

        // =====================================================================
        // Environment flags and shared helpers
        // =====================================================================

        const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        const isMobile = window.matchMedia('(max-width: 600px)').matches;
        const finePointer = window.matchMedia('(pointer: fine)').matches;

        const TAU = Math.PI * 2;
        const { clamp, lerp, damp } = THREE.MathUtils;

        const clock = new THREE.Clock();
        const raycaster = new THREE.Raycaster();

        const disposeMaterials = new Set();
        const disposeGeometries = new Set();
        const disposeTextures = new Set();

        const _v = new THREE.Vector3();
        const _c = new THREE.Color();

        // =====================================================================
        // Interaction state
        // =====================================================================

        const targetPointer = new THREE.Vector2();   // raw NDC position
        const pointer = new THREE.Vector2();         // smoothed NDC (parallax)
        const follow = new THREE.Vector2();          // fast follower (3D projection)

        let inside = false;
        let dragging = false;
        let strength = 0;          // 0..1 fades in while the pointer is over the scene
        let pointerSpeed = 0;      // 0..1 decaying measure of cursor velocity
        let idleTime = 0;
        let lastX = 0;
        let lastY = 0;
        let hasLast = false;
        let downX = 0;
        let downY = 0;
        let downTime = 0;
        let travel = 0;
        let hoveredMonolith = null;
        let pulse = 0;             // click shock energy
        let shake = 0;             // camera shake energy
        let velTheta = 0;
        let velPhi = 0;

        const shock = { pos: new THREE.Vector3(0, -3.05, 0), age: 100 };

        const mouseGround = new THREE.Vector3(0, -3.05, 0);  // cursor ray on floor plane
        const mouseWorld = new THREE.Vector3();              // cursor ray at mid depth (lights/trail)
        const groundPlane = new THREE.Plane(new THREE.Vector3(0, 1, 0), 3.05);

        let currentView = 'origin';
        let destroyed = false;
        let running = false;
        let frameCount = 0;

        // =====================================================================
        // Scene, camera, renderer
        // =====================================================================

        const scene = new THREE.Scene();
        scene.background = new THREE.Color(0x050606);
        scene.fog = new THREE.FogExp2(0x050606, 0.019);

        const camera = new THREE.PerspectiveCamera(44, 1, 0.1, 160);
        camera.position.set(0, 2.1, 15);

        let renderer;

        try {
            renderer = new THREE.WebGLRenderer({
                antialias: false,           // MSAA is handled by the composer target
                alpha: false,
                powerPreference: 'high-performance',
                depth: true
            });
        } catch (error) {
            mount.innerHTML =
                '<div style="padding:30px;color:#eeeae2;font-size:12px">WebGL could not initialize in this browser.</div>';
            document.getElementById('cathedral-loader')?.remove();
            return;
        }

        renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, isMobile ? 1.25 : 1.7));
        renderer.outputColorSpace = THREE.SRGBColorSpace;
        renderer.toneMapping = THREE.ACESFilmicToneMapping;
        renderer.toneMappingExposure = 1.15;
        mount.appendChild(renderer.domElement);

        // Image based lighting gives the metals something real to reflect.
        const pmrem = new THREE.PMREMGenerator(renderer);
        const envTexture = pmrem.fromScene(new RoomEnvironment(), 0.04).texture;
        scene.environment = envTexture;
        scene.environmentIntensity = 0.28;

        const world = new THREE.Group();
        scene.add(world);

        const architecture = new THREE.Group();
        world.add(architecture);

        const orbitSystem = new THREE.Group();
        world.add(orbitSystem);

        const networkSystem = new THREE.Group();
        world.add(networkSystem);

        // =====================================================================
        // Lighting
        // =====================================================================

        scene.add(new THREE.HemisphereLight(0xe6d8c5, 0x080b0d, 1.0));

        const keyLight = new THREE.DirectionalLight(0xffdfb8, 2.6);
        keyLight.position.set(5, 8, 7);
        scene.add(keyLight);

        const orangeLight = new THREE.PointLight(0xff6426, 95, 28, 2);
        orangeLight.position.set(0, 2.5, 1);
        scene.add(orangeLight);

        const rimLight = new THREE.PointLight(0xff9c48, 120, 35, 2);
        rimLight.position.set(-7, 5, -7);
        scene.add(rimLight);

        const lowerLight = new THREE.PointLight(0xff6c22, 45, 20, 2);
        lowerLight.position.set(2, -4, 4);
        scene.add(lowerLight);

        // A light that physically follows the cursor through the scene.
        const cursorLight = new THREE.PointLight(0xffa466, 0, 16, 2);
        cursorLight.position.set(0, 0, 8);
        scene.add(cursorLight);

        // =====================================================================
        // Material / mesh factories
        // =====================================================================

        function physicalMaterial(options = {}) {
            const material = new THREE.MeshPhysicalMaterial(options);
            disposeMaterials.add(material);
            return material;
        }

        function basicMaterial(options = {}) {
            const material = new THREE.MeshBasicMaterial(options);
            disposeMaterials.add(material);
            return material;
        }

        function addMesh(geometry, material, parent, position, scale) {
            disposeGeometries.add(geometry);
            const mesh = new THREE.Mesh(geometry, material);

            if (position) mesh.position.set(...position);
            if (scale) mesh.scale.set(...scale);

            parent.add(mesh);
            return mesh;
        }

        function makeSprite() {
            const canvas = document.createElement('canvas');
            canvas.width = canvas.height = 64;

            const ctx = canvas.getContext('2d');
            const gradient = ctx.createRadialGradient(32, 32, 0, 32, 32, 32);
            gradient.addColorStop(0, 'rgba(255,255,255,1)');
            gradient.addColorStop(0.25, 'rgba(255,255,255,.55)');
            gradient.addColorStop(1, 'rgba(255,255,255,0)');
            ctx.fillStyle = gradient;
            ctx.fillRect(0, 0, 64, 64);

            const texture = new THREE.CanvasTexture(canvas);
            texture.colorSpace = THREE.SRGBColorSpace;
            disposeTextures.add(texture);
            return texture;
        }

        const sprite = makeSprite();

        const titanium = physicalMaterial({
            color: 0x292d2d,
            metalness: 0.94,
            roughness: 0.29,
            clearcoat: 0.65,
            clearcoatRoughness: 0.25
        });

        const silver = physicalMaterial({
            color: 0xb9b6ac,
            metalness: 0.92,
            roughness: 0.22,
            clearcoat: 1
        });

        const darkMetal = physicalMaterial({
            color: 0x111515,
            metalness: 0.88,
            roughness: 0.34
        });

        const amber = physicalMaterial({
            color: 0xff792f,
            emissive: 0xf34d12,
            emissiveIntensity: 2.0,
            metalness: 0.55,
            roughness: 0.24
        });

        const gold = physicalMaterial({
            color: 0xc6a47c,
            metalness: 0.94,
            roughness: 0.2,
            emissive: 0x6d2b0a,
            emissiveIntensity: 0.35
        });

        const energyLine = basicMaterial({
            color: 0xff8b43,
            transparent: true,
            opacity: 0.8
        });

        // =====================================================================
        // Central foundation
        // =====================================================================

        const foundation = new THREE.Group();
        architecture.add(foundation);

        const foundationRings = [];

        for (let i = 0; i < 6; i++) {
            const radius = 2.4 + i * 0.57;
            const thickness = i % 2 === 0 ? 0.075 : 0.035;

            const ring = addMesh(
                new THREE.TorusGeometry(radius, thickness, 8, 160),
                i % 2 === 0 ? silver : energyLine,
                foundation,
                [0, -2.5 + i * 0.045, 0]
            );

            ring.rotation.x = Math.PI / 2;
            foundationRings.push(ring);
        }

        addMesh(
            new THREE.CylinderGeometry(3.4, 4.2, 0.32, 12, 1),
            darkMetal,
            foundation,
            [0, -2.85, 0]
        );

        addMesh(
            new THREE.CylinderGeometry(2.6, 3.4, 0.12, 48),
            silver,
            foundation,
            [0, -2.63, 0]
        );

        // =====================================================================
        // Computational cathedral core
        // =====================================================================

        const core = new THREE.Group();
        architecture.add(core);

        const rocket = new THREE.Group();
        rocket.position.set(0, 0.5, 0);
        world.add(rocket);

        const centralSpire = addMesh(
            new THREE.CylinderGeometry(0.13, 0.75, 7.5, 8, 1, false),
            titanium, rocket, [0, 0, 0]
        );
        centralSpire.rotation.y = Math.PI / 8;

        addMesh(new THREE.CylinderGeometry(0.06, 0.28, 8.4, 8), amber, rocket, [0, 0.1, 0]);

        const centralDiamond = addMesh(
            new THREE.OctahedronGeometry(1.15, 1),
            silver, rocket, [0, 0.15, 0], [0.85, 1.75, 0.85]
        );
        centralDiamond.rotation.y = Math.PI / 4;
        centralDiamond.rotation.x = Math.PI / 7;

        const innerCrystal = addMesh(new THREE.IcosahedronGeometry(0.72, 1), amber, rocket, [0, 0.05, 0]);
        innerCrystal.scale.set(0.85, 1.6, 0.85);

        for (let i = 0; i < 4; i++) {
            const a = i * Math.PI / 2 + Math.PI / 4;
            const fin = addMesh(new THREE.BoxGeometry(0.06, 1.5, 0.9), silver, rocket,
                [Math.cos(a) * 0.8, -2.9, Math.sin(a) * 0.8]);
            fin.rotation.y = Math.PI / 2 - a;
        }

        // Towers: each one reacts to the cursor's position on the floor.

        const towers = [];
        const towerCount = isMobile ? 18 : 30;

        for (let i = 0; i < towerCount; i++) {
            const angle = (i / towerCount) * TAU;
            const radius = 3.7 + Math.sin(i * 2.1) * 0.8;
            const height = 2.8 + (0.5 + 0.5 * Math.sin(i * 5.3)) * 5.3;
            const x = Math.cos(angle) * radius;
            const z = Math.sin(angle) * radius;

            const tower = new THREE.Group();
            tower.position.set(x, -2.45 + height / 2, z);
            tower.rotation.y = -angle;
            core.add(tower);

            const width = 0.22 + (i % 4) * 0.055;

            addMesh(
                new THREE.BoxGeometry(width, height, width),
                i % 5 === 0 ? silver : titanium,
                tower,
                [0, 0, 0]
            );

            const crown = addMesh(
                new THREE.ConeGeometry(width * 1.4, 0.65 + (i % 3) * 0.2, 4),
                i % 4 === 0 ? gold : darkMetal,
                tower,
                [0, height / 2 + 0.35, 0]
            );

            crown.rotation.y = Math.PI / 4;

            // Each spine owns its material so it can glow independently.
            const spineMaterial = amber.clone();
            disposeMaterials.add(spineMaterial);

            addMesh(
                new THREE.BoxGeometry(0.025, height * 0.72, 0.025),
                spineMaterial,
                tower,
                [width * 0.53, -0.03, width * 0.53]
            );

            const ledgeCount = Math.min(8, Math.floor(height / 0.8));

            for (let j = 0; j < ledgeCount; j++) {
                const y = -height / 2 + (j + 1) * height / (ledgeCount + 1);

                addMesh(
                    new THREE.BoxGeometry(width * 1.65, 0.045, width * 1.65),
                    j % 3 === 0 ? gold : darkMetal,
                    tower,
                    [0, y, 0]
                );
            }

            tower.userData = {
                baseY: tower.position.y,
                phase: i * 0.65,
                amplitude: 0.035 + (i % 4) * 0.018,
                hover: 0,
                spineMaterial
            };

            towers.push(tower);
        }

        // =====================================================================
        // Intersecting structural rings
        // =====================================================================

        const ringSpecs = [
            { radius: 5.8, tube: 0.045, rx: 0.15, ry: 0.2, rz: 0.18, material: silver },
            { radius: 6.5, tube: 0.027, rx: 1.0, ry: 0.3, rz: -0.32, material: gold },
            { radius: 7.15, tube: 0.035, rx: 0.45, ry: 0.9, rz: 0.9, material: titanium },
            { radius: 8.2, tube: 0.022, rx: 1.35, ry: 0.1, rz: 0.55, material: energyLine }
        ];

        const celestialRings = [];

        for (let i = 0; i < ringSpecs.length; i++) {
            const spec = ringSpecs[i];
            const ring = addMesh(
                new THREE.TorusGeometry(spec.radius, spec.tube, 8, 200),
                spec.material,
                orbitSystem,
                [0, 0, 0]
            );

            ring.rotation.set(spec.rx, spec.ry, spec.rz);
            ring.userData = { spin: (i % 2 ? -1 : 1) * (0.07 + i * 0.03) };
            celestialRings.push(ring);
        }

        // =====================================================================
        // Radial struts (instanced)
        // =====================================================================

        const strutCount = isMobile ? 48 : 84;
        const strutGeometry = new THREE.BoxGeometry(0.025, 0.035, 6.3);
        disposeGeometries.add(strutGeometry);

        const struts = new THREE.InstancedMesh(strutGeometry, titanium, strutCount);
        const strutDummy = new THREE.Object3D();

        for (let i = 0; i < strutCount; i++) {
            const angle = (i / strutCount) * TAU;

            strutDummy.position.set(
                Math.cos(angle) * 4.1,
                -0.4 + Math.sin(angle * 5) * 0.5,
                Math.sin(angle) * 4.1
            );

            strutDummy.rotation.set(
                Math.sin(angle) * 0.16,
                -angle,
                Math.cos(angle) * 0.15
            );

            strutDummy.updateMatrix();
            struts.setMatrixAt(i, strutDummy.matrix);
        }

        struts.instanceMatrix.needsUpdate = true;
        architecture.add(struts);

        // =====================================================================
        // Reactive data ring: a circular equaliser driven by cursor + shocks
        // =====================================================================

        const BAR_COUNT = isMobile ? 120 : 200;
        const BAR_RADIUS = 10.6;

        const barGeometry = new THREE.BoxGeometry(0.07, 1, 0.07);
        barGeometry.translate(0, 0.5, 0);
        disposeGeometries.add(barGeometry);

        const bars = new THREE.InstancedMesh(barGeometry, basicMaterial({ color: 0xffffff }), BAR_COUNT);
        bars.instanceMatrix.setUsage(THREE.DynamicDrawUsage);
        bars.frustumCulled = false;

        const barAngle = new Float32Array(BAR_COUNT);
        const barX = new Float32Array(BAR_COUNT);
        const barZ = new Float32Array(BAR_COUNT);
        const barDummy = new THREE.Object3D();

        for (let i = 0; i < BAR_COUNT; i++) {
            const angle = (i / BAR_COUNT) * TAU - Math.PI;
            barAngle[i] = angle;
            barX[i] = Math.cos(angle) * BAR_RADIUS;
            barZ[i] = Math.sin(angle) * BAR_RADIUS;
            bars.setColorAt(i, _c.setRGB(0.22, 0.1, 0.05));
        }

        bars.instanceColor.setUsage(THREE.DynamicDrawUsage);
        world.add(bars);

        function updateBars(t) {
            const mR = Math.hypot(mouseGround.x, mouseGround.z);
            const mA = Math.atan2(mouseGround.z, mouseGround.x);
            const proximity = Math.exp(-Math.pow((mR - BAR_RADIUS) / 4.2, 2)) * strength;
            const front = shock.age * 16;
            const shockFade = Math.exp(-shock.age * 0.9);

            for (let i = 0; i < BAR_COUNT; i++) {
                const a = barAngle[i];

                let da = Math.abs(a - mA);
                da = Math.min(da, TAU - da);

                let h = 0.1 + 0.28 *
                    (0.5 + 0.5 * Math.sin(a * 9 + t * 1.1)) *
                    (0.5 + 0.5 * Math.sin(a * 3 - t * 0.6));

                h += Math.exp(-da * da * 10) * 3.0 * proximity;

                const sd = Math.hypot(barX[i] - shock.pos.x, barZ[i] - shock.pos.z);
                h += Math.exp(-Math.pow((sd - front) * 0.75, 2)) * shockFade * 2.6;

                barDummy.position.set(barX[i], -3.05, barZ[i]);
                barDummy.rotation.set(0, -a, 0);
                barDummy.scale.set(1, h, 1);
                barDummy.updateMatrix();
                bars.setMatrixAt(i, barDummy.matrix);

                const k = clamp(h / 3.2, 0, 1);
                bars.setColorAt(i, _c.setRGB(lerp(0.22, 2.4, k), lerp(0.1, 0.85, k), lerp(0.05, 0.25, k)));
            }

            bars.instanceMatrix.needsUpdate = true;
            bars.instanceColor.needsUpdate = true;
        }

        // =====================================================================
        // Floating monoliths (hover + click interactive)
        // =====================================================================

        const monoliths = new THREE.Group();
        world.add(monoliths);

        const monolithCount = isMobile ? 10 : 19;
        const monolithGroups = [];
        const monolithBlocks = [];

        // Replace these with your real project names when ready.
        const monolithNames = Array.from(
            { length: monolithCount },
            (_, i) => 'ARCHIVE ' + String(i + 1).padStart(2, '0')
        );

        for (let i = 0; i < monolithCount; i++) {
            const angle = i * 2.399963;
            const radius = 8 + (i % 5) * 1.05;
            const height = 0.8 + (i % 4) * 0.55;

            const group = new THREE.Group();

            group.position.set(
                Math.cos(angle) * radius,
                (i % 2 === 0 ? 1 : -1) * (1.1 + (i % 4) * 0.45),
                Math.sin(angle) * radius - 1.5
            );

            monoliths.add(group);

            // Per-monolith material so hover can light up one at a time.
            const blockMaterial = physicalMaterial({
                color: i % 4 === 0 ? 0xc6a47c : 0x111515,
                metalness: 0.92,
                roughness: i % 4 === 0 ? 0.2 : 0.34,
                emissive: 0xff5a1a,
                emissiveIntensity: 0
            });

            const block = addMesh(
                new THREE.BoxGeometry(0.48, height, 0.42),
                blockMaterial,
                group
            );

            block.rotation.y = i * 0.25;

            addMesh(
                new THREE.BoxGeometry(0.035, height * 0.65, 0.44),
                energyLine,
                group,
                [0.22, 0, 0]
            );

            group.userData = {
                phase: i * 0.7,
                baseY: group.position.y,
                amplitude: 0.1 + (i % 3) * 0.04,
                hop: 0,
                hover: 0,
                material: blockMaterial,
                block,
                name: monolithNames[i]
            };

            monolithGroups.push(group);
            monolithBlocks.push(block);
        }

        // =====================================================================
        // GPU particle field (flow + cursor repulsion + shockwave)
        // =====================================================================

        const particleCount = isMobile ? 1400 : 4200;
        const particlePositions = new Float32Array(particleCount * 3);
        const particleSeeds = new Float32Array(particleCount * 4);

        for (let i = 0; i < particleCount; i++) {
            const radius = 7 + Math.random() * 24;
            const angle = Math.random() * TAU;

            particlePositions[i * 3] = Math.cos(angle) * radius;
            particlePositions[i * 3 + 1] = (Math.random() - 0.5) * 18;
            particlePositions[i * 3 + 2] = Math.sin(angle) * radius - 3;

            particleSeeds[i * 4] = Math.random();
            particleSeeds[i * 4 + 1] = Math.random();
            particleSeeds[i * 4 + 2] = Math.random();
            particleSeeds[i * 4 + 3] = Math.random();
        }

        const particleGeometry = new THREE.BufferGeometry();
        particleGeometry.setAttribute('position', new THREE.BufferAttribute(particlePositions, 3));
        particleGeometry.setAttribute('aSeed', new THREE.BufferAttribute(particleSeeds, 4));
        disposeGeometries.add(particleGeometry);

        const particleMaterial = new THREE.ShaderMaterial({
            transparent: true,
            depthWrite: false,
            blending: THREE.AdditiveBlending,
            uniforms: {
                uTime: { value: 0 },
                uMouse: { value: new THREE.Vector3() },
                uStrength: { value: 0 },
                uShock: { value: new THREE.Vector4(0, 0, 0, 100) },
                uSize: { value: isMobile ? 38 : 52 },
                uPixel: { value: renderer.getPixelRatio() }
            },
            vertexShader: `
                uniform float uTime;
                uniform vec3 uMouse;
                uniform float uStrength;
                uniform vec4 uShock;
                uniform float uSize;
                uniform float uPixel;

                attribute vec4 aSeed;

                varying float vAlpha;
                varying float vHeat;

                void main() {
                    vec3 p = position;
                    float t = uTime;

                    // Slow orbital drift plus per-particle bobbing.
                    float ang = t * 0.03 * (0.4 + aSeed.x);
                    float c = cos(ang);
                    float s = sin(ang);
                    p.xz = mat2(c, -s, s, c) * p.xz;
                    p.y += sin(t * 0.4 + aSeed.y * 6.2831) * 0.35 + sin(t * 0.13 + aSeed.z * 20.0) * 0.2;
                    p.x += sin(t * 0.3 + aSeed.w * 30.0) * 0.15;

                    // Cursor repulsion with a little swirl.
                    vec3 d = p - uMouse;
                    float dist = length(d);
                    float f = smoothstep(4.8, 0.0, dist) * uStrength;
                    p += normalize(d + vec3(0.0001)) * f * f * 2.4;
                    p.xz += vec2(-d.z, d.x) / (dist + 0.6) * f * 0.7;

                    // Click shockwave travelling outward.
                    float sd = distance(p, uShock.xyz);
                    float wave = exp(-pow((sd - uShock.w * 14.0) * 0.6, 2.0)) * exp(-uShock.w * 0.8);
                    p += normalize(p - uShock.xyz + vec3(0.0001)) * wave * 2.6;

                    vHeat = clamp(f * 1.2 + wave * 1.5, 0.0, 1.0);

                    vec4 mv = modelViewMatrix * vec4(p, 1.0);
                    gl_Position = projectionMatrix * mv;

                    float size = uSize * uPixel * (0.5 + aSeed.x * 1.1) * (1.0 + vHeat * 1.6) / -mv.z;
                    gl_PointSize = max(size, 1.0);

                    vAlpha = (0.35 + 0.65 * aSeed.z) * smoothstep(70.0, 10.0, -mv.z);
                }
            `,
            fragmentShader: `
                varying float vAlpha;
                varying float vHeat;

                void main() {
                    float d = length(gl_PointCoord - 0.5);
                    float a = smoothstep(0.5, 0.0, d);
                    a *= a;

                    vec3 col = mix(vec3(1.0, 0.76, 0.55), vec3(1.0, 0.4, 0.1), vHeat);
                    gl_FragColor = vec4(col * (1.0 + vHeat * 2.2), a * vAlpha);
                }
            `
        });
        disposeMaterials.add(particleMaterial);

        const particles = new THREE.Points(particleGeometry, particleMaterial);
        particles.frustumCulled = false;
        world.add(particles);

        // =====================================================================
        // Computational network with travelling data signals
        // =====================================================================

        const nodeCount = isMobile ? 42 : 90;
        const nodePositions = [];
        const nodeMeshes = [];

        for (let i = 0; i < nodeCount; i++) {
            const angle = i * 2.399963;
            const radius = 4.5 + Math.random() * 10;

            const position = new THREE.Vector3(
                Math.cos(angle) * radius,
                (Math.random() - 0.5) * 9,
                Math.sin(angle) * radius - 1
            );

            nodePositions.push(position);

            if (i % 3 === 0) {
                const node = addMesh(
                    new THREE.IcosahedronGeometry(0.045 + Math.random() * 0.035, 0),
                    amber,
                    networkSystem,
                    position.toArray()
                );

                node.userData.phase = Math.random() * TAU;
                nodeMeshes.push(node);
            }
        }

        const linePositions = [];
        const edgeA = [];
        const edgeB = [];

        for (let i = 0; i < nodePositions.length; i++) {
            const a = nodePositions[i];

            for (let j = i + 1; j < nodePositions.length; j++) {
                const b = nodePositions[j];

                if (a.distanceTo(b) < 3.4 && Math.random() > 0.35) {
                    linePositions.push(a.x, a.y, a.z, b.x, b.y, b.z);
                    edgeA.push(i);
                    edgeB.push(j);
                }
            }
        }

        const lineGeometry = new THREE.BufferGeometry();
        lineGeometry.setAttribute('position', new THREE.Float32BufferAttribute(linePositions, 3));
        disposeGeometries.add(lineGeometry);

        const networkLineMaterial = basicMaterial({
            color: 0xc87843,
            transparent: true,
            opacity: 0.22,
            depthWrite: false
        });

        networkSystem.add(new THREE.LineSegments(lineGeometry, networkLineMaterial));

        // Glowing packets that run along random edges of the graph.

        const signalCount = edgeA.length ? (isMobile ? 24 : 60) : 0;
        const signalPositions = new Float32Array(signalCount * 3);
        const signals = [];

        for (let i = 0; i < signalCount; i++) {
            signals.push({
                edge: Math.floor(Math.random() * edgeA.length),
                t: Math.random(),
                speed: 0.25 + Math.random() * 0.55
            });
        }

        const signalGeometry = new THREE.BufferGeometry();
        signalGeometry.setAttribute('position', new THREE.BufferAttribute(signalPositions, 3));
        disposeGeometries.add(signalGeometry);

        const signalMaterial = new THREE.PointsMaterial({
            color: 0xffb27a,
            size: 0.36,
            map: sprite,
            transparent: true,
            opacity: 0.95,
            depthWrite: false,
            blending: THREE.AdditiveBlending,
            sizeAttenuation: true
        });
        disposeMaterials.add(signalMaterial);

        const signalPoints = new THREE.Points(signalGeometry, signalMaterial);
        signalPoints.frustumCulled = false;
        networkSystem.add(signalPoints);

        function updateSignals(dt) {
            const boost = 1 + pointerSpeed * 3 + pulse * 4;

            for (let i = 0; i < signalCount; i++) {
                const s = signals[i];
                s.t += s.speed * dt * boost;

                if (s.t >= 1) {
                    s.t = 0;
                    s.edge = Math.floor(Math.random() * edgeA.length);
                }

                const a = nodePositions[edgeA[s.edge]];
                const b = nodePositions[edgeB[s.edge]];

                signalPositions[i * 3] = lerp(a.x, b.x, s.t);
                signalPositions[i * 3 + 1] = lerp(a.y, b.y, s.t);
                signalPositions[i * 3 + 2] = lerp(a.z, b.z, s.t);
            }

            signalGeometry.attributes.position.needsUpdate = true;
        }

        // =====================================================================
        // Interactive floor (shader grid with cursor glow and shock ripples)
        // =====================================================================

        const groundMaterial = new THREE.ShaderMaterial({
            transparent: true,
            depthWrite: false,
            blending: THREE.AdditiveBlending,
            uniforms: {
                uMouse: { value: new THREE.Vector3() },
                uStrength: { value: 0 },
                uShock: { value: new THREE.Vector4(0, 0, 0, 100) }
            },
            vertexShader: `
                varying vec3 vW;

                void main() {
                    vW = (modelMatrix * vec4(position, 1.0)).xyz;
                    gl_Position = projectionMatrix * viewMatrix * vec4(vW, 1.0);
                }
            `,
            fragmentShader: `
                uniform vec3 uMouse;
                uniform float uStrength;
                uniform vec4 uShock;

                varying vec3 vW;

                float gridLine(vec2 p, float size, float width) {
                    vec2 q = p / size;
                    vec2 g = abs(fract(q - 0.5) - 0.5) / fwidth(q);
                    float l = min(g.x, g.y);
                    return 1.0 - min(l / width, 1.0);
                }

                void main() {
                    vec2 p = vW.xz;

                    float g1 = gridLine(p, 1.0, 1.0);
                    float g2 = gridLine(p, 5.0, 1.6);

                    float r = length(p);
                    float fade = smoothstep(32.0, 6.0, r);

                    float md = distance(p, uMouse.xz);
                    float glow = exp(-md * md * 0.12) * uStrength;

                    float sd = distance(p, uShock.xz);
                    float ring = exp(-pow((sd - uShock.w * 16.0) * 0.9, 2.0)) * exp(-uShock.w * 0.9);

                    vec3 hot = vec3(1.0, 0.42, 0.12);
                    vec3 col = vec3(0.30, 0.23, 0.17) * (g1 * 0.22 + g2 * 0.55);

                    col += hot * (g1 * 0.9 + g2 * 1.4) * (glow * 0.9 + ring * 2.2);
                    col += hot * ring * 0.1;
                    col += hot * glow * 0.035;

                    gl_FragColor = vec4(col * fade, 1.0);
                }
            `
        });
        disposeMaterials.add(groundMaterial);

        const groundGeometry = new THREE.PlaneGeometry(90, 90, 1, 1);
        disposeGeometries.add(groundGeometry);

        const ground = new THREE.Mesh(groundGeometry, groundMaterial);
        ground.rotation.x = -Math.PI / 2;
        ground.position.y = -3.05;
        ground.renderOrder = -1;
        world.add(ground);

        const horizonGroup = new THREE.Group();
        world.add(horizonGroup);

        for (let i = 0; i < 12; i++) {
            const radius = 13 + i * 1.15;

            const ring = addMesh(
                new THREE.TorusGeometry(radius, 0.012, 4, 180),
                i % 3 === 0 ? energyLine : titanium,
                horizonGroup,
                [0, -3.0 - i * 0.06, -4]
            );

            ring.rotation.x = Math.PI / 2;
        }

        // =====================================================================
        // Cursor trail in 3D
        // =====================================================================

        const TRAIL_LENGTH = 42;
        const trailPositions = new Float32Array(TRAIL_LENGTH * 3);
        const trailColors = new Float32Array(TRAIL_LENGTH * 3);

        const trailGeometry = new THREE.BufferGeometry();
        trailGeometry.setAttribute('position', new THREE.BufferAttribute(trailPositions, 3));
        trailGeometry.setAttribute('color', new THREE.BufferAttribute(trailColors, 3));
        disposeGeometries.add(trailGeometry);

        const trailMaterial = new THREE.PointsMaterial({
            size: 0.5,
            map: sprite,
            vertexColors: true,
            transparent: true,
            depthWrite: false,
            blending: THREE.AdditiveBlending,
            sizeAttenuation: true
        });
        disposeMaterials.add(trailMaterial);

        const trail = new THREE.Points(trailGeometry, trailMaterial);
        trail.frustumCulled = false;
        scene.add(trail);

        function updateTrail() {
            trailPositions.copyWithin(3, 0, (TRAIL_LENGTH - 1) * 3);
            trailPositions[0] = mouseWorld.x;
            trailPositions[1] = mouseWorld.y;
            trailPositions[2] = mouseWorld.z;

            const energy = clamp(pointerSpeed * 1.6, 0, 1) * strength;

            for (let i = 0; i < TRAIL_LENGTH; i++) {
                const f = Math.pow(1 - i / TRAIL_LENGTH, 2) * energy * 2.0;
                trailColors[i * 3] = 1.0 * f;
                trailColors[i * 3 + 1] = 0.5 * f;
                trailColors[i * 3 + 2] = 0.18 * f;
            }

            trailGeometry.attributes.position.needsUpdate = true;
            trailGeometry.attributes.color.needsUpdate = true;
        }

        // =====================================================================
        // Rocket launch system
        // =====================================================================

        let baseFov = 44;
        let fovKick = 0;
        let chase = 0;
        let hoveredRocket = false;

        const ROCKET_HOME = new THREE.Vector3(0, 0.5, 0);
        const IGNITE_TIME = 3;

        const rocketState = {
            phase: 'idle', timer: 0, progress: 0, thrust: 0, heat: 0, boost: 0, roll: 0,
            speed: 0, emit: 0, count: 4, duration: 14,
            curve: null, target: null, uStart: 0.4, uEnd: 0.6,
            scanned: false, done: false, aim: new THREE.Quaternion()
        };

        const _Y = new THREE.Vector3(0, 1, 0);
        const _Z = new THREE.Vector3(0, 0, 1);
        const _look = new THREE.Vector3();
        const _prev = new THREE.Vector3();
        const _tan = new THREE.Vector3();
        const _tail = new THREE.Vector3();
        const _dir = new THREE.Vector3();
        const _p = new THREE.Vector3();
        const _qa = new THREE.Quaternion();
        const _qr = new THREE.Quaternion();

        const lrPhase = document.getElementById('lr-phase');
        const lrCount = document.getElementById('lr-count');
        const lrAlt = document.getElementById('lr-alt');
        const lrVel = document.getElementById('lr-vel');

        function setReadout(phase, message) {
            if (lrPhase) lrPhase.textContent = phase;
            if (lrCount) lrCount.textContent = message;
        }

        const rocketPickGeometry = new THREE.CylinderGeometry(1.25, 1.25, 8.8, 10);
        const rocketPickMaterial = new THREE.MeshBasicMaterial({ visible: false });
        disposeGeometries.add(rocketPickGeometry);
        disposeMaterials.add(rocketPickMaterial);
        const rocketPick = new THREE.Mesh(rocketPickGeometry, rocketPickMaterial);
        rocket.add(rocketPick);

        function pickRocket(ndc) {
            if (rocketState.phase !== 'idle') return false;
            raycaster.setFromCamera(ndc, camera);
            return raycaster.intersectObject(rocketPick, false).length > 0;
        }

        const flameGeometry = new THREE.ConeGeometry(0.5, 1, 20, 1, true);
        flameGeometry.rotateX(Math.PI);
        flameGeometry.translate(0, -0.5, 0);
        disposeGeometries.add(flameGeometry);

        const flameOptions = {
            transparent: true, opacity: 0, depthWrite: false,
            blending: THREE.AdditiveBlending, side: THREE.DoubleSide
        };
        const flameMaterial = basicMaterial({ color: 0xff8a3d, ...flameOptions });
        const flameInnerMaterial = basicMaterial({ color: 0xfff0d0, ...flameOptions });
        const flame = new THREE.Mesh(flameGeometry, flameMaterial);
        flame.position.y = -3.75;
        flame.visible = false;
        rocket.add(flame);

        const flameInner = new THREE.Mesh(flameGeometry, flameInnerMaterial);
        flameInner.scale.set(0.5, 0.7, 0.5);
        flame.add(flameInner);

        const rocketLight = new THREE.PointLight(0xff7a2a, 0, 24, 2);
        scene.add(rocketLight);

        const EXHAUST = isMobile ? 160 : 340;
        const exPos = new Float32Array(EXHAUST * 3).fill(-999);
        const exVel = new Float32Array(EXHAUST * 3);
        const exLife = new Float32Array(EXHAUST);
        const exTtl = new Float32Array(EXHAUST).fill(1);
        const exSize = new Float32Array(EXHAUST);
        let exHead = 0;

        const exGeometry = new THREE.BufferGeometry();
        exGeometry.setAttribute('position', new THREE.BufferAttribute(exPos, 3));
        exGeometry.setAttribute('aLife', new THREE.BufferAttribute(exLife, 1));
        exGeometry.setAttribute('aSize', new THREE.BufferAttribute(exSize, 1));
        disposeGeometries.add(exGeometry);

        const exMaterial = new THREE.ShaderMaterial({
            transparent: true, depthWrite: false, blending: THREE.AdditiveBlending,
            uniforms: { uPixel: { value: renderer.getPixelRatio() } },
            vertexShader: `
                attribute float aLife;
                attribute float aSize;
                uniform float uPixel;
                varying float vLife;
                void main() {
                    vLife = aLife;
                    vec4 mv = modelViewMatrix * vec4(position, 1.0);
                    gl_Position = projectionMatrix * mv;
                    gl_PointSize = aSize * uPixel * (0.4 + (1.0 - aLife) * 1.4) * 60.0 / -mv.z;
                }
            `,
            fragmentShader: `
                varying float vLife;
                void main() {
                    float d = length(gl_PointCoord - 0.5);
                    float a = smoothstep(0.5, 0.0, d);
                    a *= a;
                    vec3 col = mix(vec3(0.55, 0.12, 0.03), vec3(1.0, 0.82, 0.5), vLife);
                    gl_FragColor = vec4(col * (0.6 + vLife * 1.6), a * vLife);
                }
            `
        });
        disposeMaterials.add(exMaterial);

        const exhaust = new THREE.Points(exGeometry, exMaterial);
        exhaust.frustumCulled = false;
        world.add(exhaust);

        function emitExhaust(count, speed) {
            rocket.updateMatrixWorld();
            _tail.set(0, -3.8, 0).applyMatrix4(rocket.matrixWorld);
            _dir.set(0, -1, 0).applyQuaternion(rocket.quaternion);
            const scale = rocket.scale.x;

            for (let k = 0; k < count; k++) {
                const i = exHead, j = i * 3;
                exHead = (exHead + 1) % EXHAUST;
                exPos[j] = _tail.x + (Math.random() - 0.5) * 0.35 * scale;
                exPos[j + 1] = _tail.y + (Math.random() - 0.5) * 0.2 * scale;
                exPos[j + 2] = _tail.z + (Math.random() - 0.5) * 0.35 * scale;
                const sp = speed * (0.7 + Math.random() * 0.6);
                exVel[j] = _dir.x * sp + (Math.random() - 0.5) * 1.8;
                exVel[j + 1] = _dir.y * sp + (Math.random() - 0.5) * 1.8;
                exVel[j + 2] = _dir.z * sp + (Math.random() - 0.5) * 1.8;
                exTtl[i] = 0.6 + Math.random() * 0.9;
                exLife[i] = 1;
                exSize[i] = (0.5 + Math.random() * 0.9) * (0.4 + scale * 0.6);
            }
        }

        function updateExhaust(dt) {
            const drag = Math.max(0, 1 - dt * 1.4);
            for (let i = 0; i < EXHAUST; i++) {
                if (exLife[i] <= 0) continue;
                const j = i * 3;
                exLife[i] -= dt / exTtl[i];
                if (exLife[i] <= 0) {
                    exLife[i] = 0;
                    exPos[j + 1] = -999;
                    continue;
                }
                exVel[j] *= drag; exVel[j + 1] *= drag; exVel[j + 2] *= drag;
                exPos[j] += exVel[j] * dt;
                exPos[j + 1] += exVel[j + 1] * dt;
                exPos[j + 2] += exVel[j + 2] * dt;
                if (exPos[j + 1] < -2.95 && exVel[j + 1] < 0) {
                    exPos[j + 1] = -2.95;
                    exVel[j + 1] *= -0.2;
                    exVel[j] *= 1.8;
                    exVel[j + 2] *= 1.8;
                }
            }
            exGeometry.attributes.position.needsUpdate = true;
            exGeometry.attributes.aLife.needsUpdate = true;
            exGeometry.attributes.aSize.needsUpdate = true;
        }

        const ringGeometry = new THREE.TorusGeometry(1, 0.018, 6, 96);
        disposeGeometries.add(ringGeometry);
        const sonicRings = [];
        for (let i = 0; i < 6; i++) {
            const ring = new THREE.Mesh(ringGeometry, basicMaterial({
                color: 0xffb27a, transparent: true, opacity: 0,
                depthWrite: false, blending: THREE.AdditiveBlending
            }));
            ring.visible = false;
            ring.userData = { age: 1, size: 1 };
            world.add(ring);
            sonicRings.push(ring);
        }

        function spawnRing(position, normal, size) {
            const ring = sonicRings.find(r => !r.visible);
            if (!ring) return;
            ring.visible = true;
            ring.userData.age = 0;
            ring.userData.size = size;
            ring.position.copy(position);
            ring.quaternion.setFromUnitVectors(_Z, normal);
        }

        function updateRings(dt) {
            for (const ring of sonicRings) {
                if (!ring.visible) continue;
                const u = ring.userData;
                u.age += dt / 1.1;
                if (u.age >= 1) { ring.visible = false; continue; }
                ring.scale.setScalar((0.5 + u.age * 7) * u.size);
                ring.material.opacity = Math.pow(1 - u.age, 2) * 0.9;
            }
        }

        function buildFlightPath(target) {
            target.getWorldPosition(_p);
            const tp = _p.clone();
            const out = new THREE.Vector3(tp.x, 0, tp.z).normalize();
            const side = new THREE.Vector3(-out.z, 0, out.x);
            const R = 2.6;
            const pts = [
                ROCKET_HOME.clone(),
                new THREE.Vector3(0, 4.5, 0),
                new THREE.Vector3(0, 10, 0),
                tp.clone().multiplyScalar(0.35).setY(15)
            ];
            for (let k = 0; k < 6; k++) {
                const a = Math.PI + k * TAU / 6;
                pts.push(new THREE.Vector3(
                    tp.x + out.x * Math.cos(a) * R + side.x * Math.sin(a) * R,
                    tp.y + Math.sin(a) * 1.2 + 0.4,
                    tp.z + out.z * Math.cos(a) * R + side.z * Math.sin(a) * R
                ));
            }
            pts.push(
                tp.clone().multiplyScalar(0.3).setY(12),
                new THREE.Vector3(0, 7.5, 0),
                new THREE.Vector3(0, 3.5, 0),
                ROCKET_HOME.clone()
            );
            const curve = new THREE.CatmullRomCurve3(pts, false, 'centripetal');
            curve.arcLengthDivisions = 400;
            const lengths = curve.getLengths(400);
            const total = lengths[lengths.length - 1];
            const at = i => lengths[Math.round(i / (pts.length - 1) * 400)] / total;
            rocketState.curve = curve;
            rocketState.uStart = at(4);
            rocketState.uEnd = at(9);
        }

        function launchRocket() {
            const s = rocketState;
            if (s.phase !== 'idle' || clock.elapsedTime < 3.4) return;
            let pick;
            do {
                pick = monolithGroups[Math.floor(Math.random() * monolithGroups.length)];
            } while (pick === s.target && monolithGroups.length > 1);
            s.target = pick;
            s.phase = 'ignite';
            s.timer = 0;
            s.count = 4;
            s.scanned = false;
            s.done = false;
            idleTime = 0;
            setReadout('IGNITION', 'T-3');
            root.classList.add('is-launching');
        }

        function liftoff() {
            const s = rocketState;
            buildFlightPath(s.target);
            s.phase = 'flight';
            s.progress = 0;
            s.roll = 0;
            s.aim.copy(rocket.quaternion);
            rocket.position.copy(ROCKET_HOME);
            triggerShock(_p.set(0, -3.05, 0));
            spawnRing(_p.set(0, -2.9, 0), _Y, 2.6);
            shake = 1;
            setReadout('LIFTOFF', 'TRACKING ' + s.target.userData.name);
        }

        function boostRocket() {
            const s = rocketState;
            if (s.phase !== 'flight') return;
            s.boost = 1;
            pulse = Math.max(pulse, 0.8);
            shake = Math.max(shake, 0.6);
            _dir.set(0, 1, 0).applyQuaternion(s.aim);
            spawnRing(rocket.position, _dir, 1.2);
        }

        function land() {
            const s = rocketState;
            s.phase = 'idle';
            s.thrust = 0;
            rocket.position.copy(ROCKET_HOME);
            rocket.scale.setScalar(1);
            rocket.quaternion.identity();
            triggerShock(_p.set(0, -3.05, 0));
            spawnRing(_p.set(0, -2.9, 0), _Y, 2);
            setReadout('TOUCHDOWN', 'CLICK THE SPIRE TO LAUNCH AGAIN');
            root.classList.remove('is-launching');
        }

        function updateRocket(dt) {
            const s = rocketState;
            const hot = hoveredRocket && inside && s.phase === 'idle';
            s.boost = damp(s.boost, 0, 1.6, dt);
            fovKick = damp(fovKick, s.boost * 9, 6, dt);
            chase = damp(chase, s.phase === 'flight' ? 1 : 0, 2.2, dt);

            if (s.phase === 'idle') {
                s.thrust = damp(s.thrust, 0, 6, dt);
                s.heat = damp(s.heat, hot ? 0.45 : 0, 6, dt);
                if (!reducedMotion) rocket.rotation.y += dt * 0.09;
            } else if (s.phase === 'ignite') {
                s.timer += dt;
                const k = clamp(s.timer / IGNITE_TIME, 0, 1);
                s.thrust = k * 0.75;
                s.heat = k;
                rocket.position.set(
                    ROCKET_HOME.x + (Math.random() - 0.5) * 0.06 * k,
                    ROCKET_HOME.y + (Math.random() - 0.5) * 0.04 * k,
                    ROCKET_HOME.z + (Math.random() - 0.5) * 0.06 * k
                );
                shake = Math.max(shake, 0.12 + k * 0.5);
                pulse = Math.max(pulse, k * 0.4);
                const n = 3 - Math.floor(s.timer);
                if (n > 0 && n !== s.count) {
                    s.count = n;
                    setReadout('IGNITION', 'T-' + n);
                    spawnRing(_p.set(0, -2.9, 0), _Y, 1.2 + k);
                }
                if (s.timer >= IGNITE_TIME) liftoff();
            } else {
                s.progress = Math.min(1, s.progress + dt / s.duration * (1 + s.boost * 2.2));
                const u = s.progress;
                const pe = lerp(u, u * u * (3 - 2 * u), 0.55);
                _prev.copy(rocket.position);
                s.curve.getPointAt(pe, rocket.position);
                s.curve.getTangentAt(pe, _tan);
                _qa.setFromUnitVectors(_Y, _tan);
                s.aim.slerp(_qa, 1 - Math.exp(-dt * 7));
                s.roll += dt * (0.9 + s.boost * 9);
                rocket.quaternion.copy(s.aim).multiply(_qr.setFromAxisAngle(_Y, s.roll));
                const shrink = THREE.MathUtils.smoothstep(u, 0, 0.14);
                const grow = THREE.MathUtils.smoothstep(u, 0.86, 1);
                rocket.scale.setScalar(lerp(1, 0.4, shrink) * lerp(1, 2.5, grow));
                s.thrust = damp(s.thrust, 1 - grow * 0.5 + s.boost * 0.8, 3, dt);
                s.heat = s.thrust;
                s.speed = damp(s.speed, _prev.distanceTo(rocket.position) / Math.max(dt, 1e-4), 6, dt);
                if (!s.scanned && u >= s.uStart) {
                    s.scanned = true;
                    setReadout('ORBIT', 'SCANNING ' + s.target.userData.name);
                }
                if (s.scanned && !s.done && u >= s.uEnd) {
                    s.done = true;
                    activateMonolith(s.target);
                    pulse = 1;
                    setReadout('SCAN COMPLETE', 'RETURNING TO BASE');
                }
                if (u >= 1) land();
            }

            if (s.target) {
                const scanning = s.phase === 'flight' && s.scanned && !s.done;
                s.target.userData.glow = damp(s.target.userData.glow || 0, scanning ? 1.5 : 0, 4, dt);
            }

            s.emit += s.thrust * (s.phase === 'flight' ? 300 : 160) * dt;
            const n = Math.floor(s.emit);
            s.emit -= n;
            if (n > 0 && s.thrust > 0.05) emitExhaust(Math.min(n, 12), 4 + s.thrust * 6);
            updateExhaust(dt);
            updateRings(dt);

            const f = s.thrust;
            flame.visible = f > 0.03;
            if (flame.visible) {
                const flicker = 0.85 + Math.random() * 0.3;
                flame.scale.set(1 + f * 0.25, (0.3 + f * 3.4) * flicker, 1 + f * 0.25);
                flameMaterial.opacity = clamp(f * 1.3, 0, 0.85);
                flameInnerMaterial.opacity = clamp(f * 1.5, 0, 0.95);
            }
            rocket.updateMatrixWorld();
            rocketLight.position.copy(_tail.set(0, -3.8, 0).applyMatrix4(rocket.matrixWorld));
            rocketLight.intensity = f * 70;

            if (frameCount % 4 === 0 && lrAlt) {
                const alt = Math.max(0, Math.round((rocket.position.y - ROCKET_HOME.y) * 12));
                lrAlt.textContent = 'ALT ' + String(alt).padStart(3, '0') + ' M';
                lrVel.textContent = 'VEL ' + String(Math.round(s.speed * 14)).padStart(3, '0') + ' M/S';
            }
        }

        // =====================================================================
        // Post-processing: bloom + lens warp + chromatic aberration
        // =====================================================================

        const composerTarget = new THREE.WebGLRenderTarget(1, 1, {
            type: THREE.HalfFloatType,
            samples: isMobile ? 0 : 4
        });

        const composer = new EffectComposer(renderer, composerTarget);
        const renderPass = new RenderPass(scene, camera);
        const bloomPass = new UnrealBloomPass(new THREE.Vector2(512, 512), 0.55, 0.65, 0.9);

        const fxPass = new ShaderPass({
            uniforms: {
                tDiffuse: { value: null },
                uTime: { value: 0 },
                uRes: { value: new THREE.Vector2(1, 1) },
                uPointer: { value: new THREE.Vector2(0.5, 0.5) },
                uSpeed: { value: 0 },
                uPulse: { value: 0 }
            },
            vertexShader: `
                varying vec2 vUv;

                void main() {
                    vUv = uv;
                    gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0);
                }
            `,
            fragmentShader: `
                uniform sampler2D tDiffuse;
                uniform float uTime;
                uniform vec2 uRes;
                uniform vec2 uPointer;
                uniform float uSpeed;
                uniform float uPulse;

                varying vec2 vUv;

                void main() {
                    vec2 uv = vUv;
                    vec2 aspect = vec2(uRes.x / uRes.y, 1.0);

                    // Gentle lens bulge around the cursor.
                    vec2 d = uv - uPointer;
                    float r = length(d * aspect);
                    float lens = exp(-r * r * 16.0) * (0.01 + uSpeed * 0.035 + uPulse * 0.02);
                    uv -= d * lens;

                    // Radial chromatic aberration that grows with motion and shocks.
                    vec2 c = uv - 0.5;
                    float ab = 0.0008 + dot(c, c) * 0.004 + uSpeed * 0.004 + uPulse * 0.006;

                    vec3 col;
                    col.r = texture2D(tDiffuse, uv + c * ab * 1.5).r;
                    col.g = texture2D(tDiffuse, uv).g;
                    col.b = texture2D(tDiffuse, uv - c * ab * 1.5).b;

                    // Fine film grain.
                    float n = fract(sin(dot(vUv * uRes + uTime * 61.0, vec2(12.9898, 78.233))) * 43758.5453);
                    col += (n - 0.5) * 0.018;

                    // Soft lens vignette.
                    float v = smoothstep(1.1, 0.35, length(c * vec2(1.0, 0.92)));
                    col *= mix(0.6, 1.0, v);

                    gl_FragColor = vec4(col, 1.0);
                }
            `
        });

        const outputPass = new OutputPass();

        composer.addPass(renderPass);
        composer.addPass(bloomPass);
        composer.addPass(fxPass);
        composer.addPass(outputPass);

        // =====================================================================
        // Camera rig: spherical orbit with inertia, zoom and idle drift
        // =====================================================================

        const views = {
            origin: { position: [0, 1.2, 15], target: [0, 0, 0] },
            architecture: { position: [7.5, 2.1, 12.5], target: [0, 0, 0] },
            network: { position: [-8, 0.8, 13], target: [0, 0, -1] },
            horizon: { position: [0, 5.8, 19], target: [0, -0.5, -2] }
        };

        const viewNames = Object.keys(views);

        function sphericalFrom(position, target) {
            const v = new THREE.Vector3(...position).sub(new THREE.Vector3(...target));
            const radius = v.length();

            return {
                radius,
                theta: Math.atan2(v.x, v.z),
                phi: Math.acos(clamp(v.y / radius, -1, 1))
            };
        }

        const PHI_MIN = 0.45;
        const PHI_MAX = 1.75;
        const RADIUS_MIN = 7;
        const RADIUS_MAX = 30;

        const cameraTarget = new THREE.Vector3(...views.origin.target);
        const orbitTarget = sphericalFrom(views.origin.position, views.origin.target);

        // Start far away and tilted so the entrance is a smooth fly-in.
        const orbit = reducedMotion
            ? { ...orbitTarget }
            : {
                radius: orbitTarget.radius * 1.9,
                theta: orbitTarget.theta + 0.9,
                phi: orbitTarget.phi - 0.2
            };

        function changeView(name) {
            const view = views[name];
            if (!view) return;

            currentView = name;
            idleTime = 0;
            velTheta = 0;
            velPhi = 0;

            const next = sphericalFrom(view.position, view.target);

            // Rotate the short way round.
            let theta = next.theta;
            while (theta - orbitTarget.theta > Math.PI) theta -= TAU;
            while (theta - orbitTarget.theta < -Math.PI) theta += TAU;

            const duration = reducedMotion ? 0.01 : 1.9;

            gsap.to(orbitTarget, {
                theta,
                phi: next.phi,
                radius: next.radius,
                duration,
                ease: 'power3.inOut',
                overwrite: true
            });

            gsap.to(cameraTarget, {
                x: view.target[0],
                y: view.target[1],
                z: view.target[2],
                duration,
                ease: 'power3.inOut',
                overwrite: true
            });

            root.querySelectorAll('.world-marker').forEach(button => {
                button.classList.toggle('is-active', button.dataset.view === name);
            });
        }

        root.querySelectorAll('.world-marker').forEach(button => {
            button.addEventListener('click', () => changeView(button.dataset.view));
        });

        document.getElementById('enter-world')?.addEventListener('click', () => {
            changeView(viewNames[(viewNames.indexOf(currentView) + 1) % viewNames.length]);
        });

        // =====================================================================
        // Cursor visuals and magnetic UI
        // =====================================================================

        const cursorEl = root.querySelector('.cathedral-cursor');
        const cursorDot = root.querySelector('.cursor-dot');
        const cursorRing = root.querySelector('.cursor-ring');
        const cursorLabel = root.querySelector('.cursor-label');

        const cursorPos = { x: 0, y: 0 };
        const ringPos = { x: 0, y: 0 };

        const magnets = Array.from(root.querySelectorAll('.enter-world, .world-marker'));

        function updateMagnets(clientX, clientY) {
            if (!finePointer || reducedMotion) return;

            for (const el of magnets) {
                const rect = el.getBoundingClientRect();
                const dx = clientX - (rect.left + rect.width / 2);
                const dy = clientY - (rect.top + rect.height / 2);
                const distance = Math.hypot(dx, dy);
                const range = 110;

                if (distance < range) {
                    const pull = (1 - distance / range) * 0.28;
                    el.style.translate = (dx * pull).toFixed(1) + 'px ' + (dy * pull).toFixed(1) + 'px';
                } else if (el.style.translate) {
                    el.style.translate = '';
                }
            }
        }

        // =====================================================================
        // Ray helpers
        // =====================================================================

        function projectToGround(ndc, out) {
            raycaster.setFromCamera(ndc, camera);

            if (!raycaster.ray.intersectPlane(groundPlane, out)) {
                out.copy(raycaster.ray.origin).addScaledVector(raycaster.ray.direction, 40);
                out.y = -3.05;
            }

            const flat = Math.hypot(out.x, out.z);
            if (flat > 30) {
                out.x *= 30 / flat;
                out.z *= 30 / flat;
            }

            return out;
        }

        function projectToDepth(ndc, out, distance) {
            raycaster.setFromCamera(ndc, camera);
            return out.copy(raycaster.ray.origin).addScaledVector(raycaster.ray.direction, distance);
        }

        function pickMonolith(ndc) {
            raycaster.setFromCamera(ndc, camera);
            const hits = raycaster.intersectObjects(monolithBlocks, false);
            return hits.length ? hits[0].object.parent : null;
        }

        function triggerShock(point) {
            shock.pos.copy(point);
            shock.age = 0;
            pulse = 1;
            shake = 1;
        }

        function activateMonolith(group) {
            idleTime = 0;

            gsap.to(group.rotation, {
                y: group.rotation.y + Math.PI / 3,
                duration: reducedMotion ? 0.01 : 0.9,
                ease: 'power3.out'
            });

            gsap.to(group.userData, {
                hop: 0.35,
                duration: reducedMotion ? 0.01 : 0.35,
                yoyo: true,
                repeat: 1,
                ease: 'power2.out'
            });

            pulse = Math.max(pulse, 0.5);
        }

        function handleTap() {
            if (rocketState.phase === 'flight') { boostRocket(); return; }
            if (rocketState.phase === 'ignite') return;
            if (pickRocket(targetPointer)) { launchRocket(); return; }
            const group = pickMonolith(targetPointer);
            if (group) activateMonolith(group);
            else triggerShock(projectToGround(targetPointer, _v));
        }

        // =====================================================================
        // Pointer events (listen on the whole section so UI layers never block)
        // =====================================================================

        function setPointerFromEvent(event) {
            const rect = mount.getBoundingClientRect();

            targetPointer.set(
                ((event.clientX - rect.left) / rect.width) * 2 - 1,
                -((event.clientY - rect.top) / rect.height) * 2 + 1
            );

            return rect;
        }

        function onPointerMove(event) {
            const rect = setPointerFromEvent(event);

            inside = true;
            idleTime = 0;

            if (!hasLast) {
                lastX = event.clientX;
                lastY = event.clientY;
                hasLast = true;
                follow.copy(targetPointer);
                pointer.copy(targetPointer);
            }

            const dx = event.clientX - lastX;
            const dy = event.clientY - lastY;
            const step = Math.hypot(dx, dy);

            lastX = event.clientX;
            lastY = event.clientY;

            pointerSpeed = Math.min(1, pointerSpeed + (step / rect.height) * 3.5);

            if (dragging) {
                travel += step;

                orbitTarget.theta -= dx * 0.0055;
                orbitTarget.phi = clamp(orbitTarget.phi - dy * 0.004, PHI_MIN, PHI_MAX);

                velTheta = lerp(velTheta, (-dx * 0.0055) * 60, 0.35);
                velPhi = lerp(velPhi, (-dy * 0.004) * 60, 0.35);
            }

            if (cursorEl) {
                cursorPos.x = event.clientX - rect.left;
                cursorPos.y = event.clientY - rect.top;
                cursorEl.classList.add('is-visible');
                cursorEl.classList.toggle('is-ui', !!event.target.closest?.('a, button'));
            }

            updateMagnets(event.clientX, event.clientY);
        }

        function onPointerEnter() {
            inside = true;
        }

        function onPointerLeave() {
            inside = false;
            hasLast = false;
            targetPointer.set(0, 0);
            hoveredMonolith = null;
            cursorEl?.classList.remove('is-visible', 'is-hot');

            magnets.forEach(el => { el.style.translate = ''; });
        }

        function onPointerDown(event) {
            if (event.button !== 0) return;

            setPointerFromEvent(event);

            if (event.pointerType === 'touch') {
                inside = true;
                follow.copy(targetPointer);
                pointer.copy(targetPointer);
            }

            dragging = true;
            travel = 0;
            downX = event.clientX;
            downY = event.clientY;
            downTime = performance.now();
            idleTime = 0;
            velTheta = 0;
            velPhi = 0;

            gsap.killTweensOf(orbitTarget);

            cursorEl?.classList.add('is-down');

            try {
                mount.setPointerCapture(event.pointerId);
            } catch (error) { /* capture is optional */ }
        }

        function onPointerUp(event) {
            cursorEl?.classList.remove('is-down');

            if (!dragging) return;
            dragging = false;

            const quick = performance.now() - downTime < 500;
            const still = travel < 6 && Math.hypot(event.clientX - downX, event.clientY - downY) < 6;

            if (quick && still) handleTap();

            if (event.pointerType === 'touch') {
                inside = false;
                hasLast = false;
            }
        }

        function onPointerCancel() {
            dragging = false;
            cursorEl?.classList.remove('is-down');
        }

        // Shift + wheel (or trackpad pinch) zooms without hijacking page scroll.
        function onWheel(event) {
            if (!event.ctrlKey && !event.shiftKey) return;

            event.preventDefault();
            idleTime = 0;

            const delta = event.deltaY || event.deltaX;
            orbitTarget.radius = clamp(
                orbitTarget.radius * Math.exp(delta * 0.0014),
                RADIUS_MIN,
                RADIUS_MAX
            );
        }

        function onKeyDown(event) {
            if (!visible || event.metaKey || event.ctrlKey || event.altKey) return;

            const tag = event.target?.tagName;
            if (tag === 'INPUT' || tag === 'TEXTAREA' || tag === 'SELECT') return;

            if (event.key === 'l' || event.key === 'L') {
                if (rocketState.phase === 'flight') boostRocket(); else launchRocket();
                return;
            }

            const index = ['1', '2', '3', '4'].indexOf(event.key);
            if (index > -1) changeView(viewNames[index]);
        }

        root.addEventListener('pointermove', onPointerMove, { passive: true });
        root.addEventListener('pointerenter', onPointerEnter);
        root.addEventListener('pointerleave', onPointerLeave);
        mount.addEventListener('pointerdown', onPointerDown);
        mount.addEventListener('wheel', onWheel, { passive: false });
        window.addEventListener('pointerup', onPointerUp);
        window.addEventListener('pointercancel', onPointerCancel);
        window.addEventListener('keydown', onKeyDown);

        // =====================================================================
        // Responsive sizing
        // =====================================================================

        function resize() {
            if (destroyed) return;

            const width = Math.max(1, mount.clientWidth);
            const height = Math.max(1, mount.clientHeight);

            renderer.setSize(width, height, false);

            composer.setPixelRatio(renderer.getPixelRatio());
            composer.setSize(width, height);

            fxPass.uniforms.uRes.value.set(width, height);
            particleMaterial.uniforms.uPixel.value = renderer.getPixelRatio();

            camera.aspect = width / height;
            baseFov = width < 600 ? 52 : 44;
            camera.fov = baseFov + fovKick;
            camera.updateProjectionMatrix();
        }

        const resizeObserver = new ResizeObserver(resize);
        resizeObserver.observe(mount);
        resize();

        // =====================================================================
        // Cinematic entrance
        // =====================================================================

        const loader = document.getElementById('cathedral-loader');
        const loaderProgress = document.getElementById('loader-progress');
        const loaderPercent = document.getElementById('loader-percent');
        const intro = root.querySelector('.cathedral-intro');
        const header = root.querySelector('.cathedral-header');
        const index = root.querySelector('.cathedral-index');
        const bottom = root.querySelector('.cathedral-bottom');
        const right = root.querySelector('.cathedral-right');
        const introTitleLines = root.querySelectorAll('.cathedral-intro h1 > span');
        const introBlocks = root.querySelectorAll('.intro-overline, .intro-description, .intro-bottom');

        // Compile shaders up front so the first visible frame doesn't hitch.
        renderer.compile(scene, camera);

        const loadState = { value: 0 };

        const introTimeline = gsap.timeline({
            onComplete: () => loader?.remove()
        });

        introTimeline
            .to(loadState, {
                value: 100,
                duration: reducedMotion ? 0.05 : 1.3,
                ease: 'power2.inOut',
                onUpdate: () => {
                    loaderProgress.style.width = loadState.value + '%';
                    loaderPercent.textContent =
                        'INITIALIZING ' + String(Math.round(loadState.value)).padStart(2, '0') + '%';
                }
            })
            .to(loader, {
                autoAlpha: 0,
                duration: reducedMotion ? 0.01 : 0.8,
                ease: 'power2.inOut'
            })
            .fromTo(header, { y: -15, autoAlpha: 0 }, {
                y: 0,
                autoAlpha: 1,
                duration: reducedMotion ? 0.01 : 0.8
            }, '-=0.25')
            .to(intro, {
                autoAlpha: 1,
                duration: reducedMotion ? 0.01 : 0.6
            }, '-=0.35')
            .from(introTitleLines, {
                y: 46,
                autoAlpha: 0,
                stagger: reducedMotion ? 0 : 0.12,
                duration: reducedMotion ? 0.01 : 1.1,
                ease: 'power3.out'
            }, '<')
            .from(introBlocks, {
                y: 20,
                autoAlpha: 0,
                stagger: reducedMotion ? 0 : 0.14,
                duration: reducedMotion ? 0.01 : 0.9,
                ease: 'power3.out'
            }, '-=0.7')
            .fromTo(index, { autoAlpha: 0 }, {
                autoAlpha: 1,
                duration: reducedMotion ? 0.01 : 0.8
            }, '-=0.8')
            .fromTo(bottom, { y: 10, autoAlpha: 0 }, {
                y: 0,
                autoAlpha: 1,
                duration: reducedMotion ? 0.01 : 0.7
            }, '-=0.5');

        if (right) {
            introTimeline.fromTo(right, { autoAlpha: 0 }, {
                autoAlpha: 1,
                duration: reducedMotion ? 0.01 : 0.7
            }, '-=0.5');
        }

        if (!reducedMotion) {
            gsap.fromTo(core.scale, { x: 0.15, y: 0.15, z: 0.15 }, {
                x: 1,
                y: 1,
                z: 1,
                duration: 2.6,
                ease: 'elastic.out(1, 0.7)'
            });
            gsap.fromTo(rocket.scale, { x: 0.15, y: 0.15, z: 0.15 }, {
                x: 1, y: 1, z: 1, duration: 2.6, ease: 'elastic.out(1, 0.7)'
            });

            gsap.fromTo(orbitSystem.rotation, { y: -0.65 }, {
                y: 0,
                duration: 3.5,
                ease: 'power3.out'
            });

            gsap.to(innerCrystal.rotation, {
                y: Math.PI * 2,
                duration: 24,
                repeat: -1,
                ease: 'none'
            });

            gsap.to(centralDiamond.rotation, {
                y: centralDiamond.rotation.y + Math.PI * 2,
                duration: 36,
                repeat: -1,
                ease: 'none'
            });
        }

        // =====================================================================
        // Render loop
        // =====================================================================

        const hudCoord = document.getElementById('hud-coord');
        const hudFps = document.getElementById('hud-fps');
        const clockElement = document.getElementById('scene-clock');

        const fmt = value => (value < 0 ? '-' : '+') + Math.abs(value).toFixed(1).padStart(4, '0');

        let qualityTimer = 0;
        let frameAccumulator = 0;
        let frameSamples = 0;
        let currentPixelRatio = renderer.getPixelRatio();
        let lastCssX = 99;
        let lastCssY = 99;

        function frame() {
            if (destroyed) return;

            const dt = Math.min(clock.getDelta(), 0.05);
            const t = clock.elapsedTime;
            frameCount++;

            // ----- Input smoothing -----------------------------------------

            pointer.x = damp(pointer.x, targetPointer.x, 4, dt);
            pointer.y = damp(pointer.y, targetPointer.y, 4, dt);
            follow.x = damp(follow.x, targetPointer.x, 14, dt);
            follow.y = damp(follow.y, targetPointer.y, 14, dt);

            pointerSpeed = damp(pointerSpeed, 0, 3.5, dt);
            strength = damp(strength, inside ? 1 : 0, 4, dt);

            shock.age += dt;
            pulse = damp(pulse, 0, 2.6, dt);
            shake = damp(shake, 0, 5, dt);
            idleTime += dt;
            updateRocket(dt);

            // ----- Camera orbit --------------------------------------------

            if (!dragging) {
                orbitTarget.theta += velTheta * dt;
                orbitTarget.phi = clamp(orbitTarget.phi + velPhi * dt, PHI_MIN, PHI_MAX);

                const decay = Math.exp(-dt * 3.2);
                velTheta *= decay;
                velPhi *= decay;
            }

            if (idleTime > 6 && !reducedMotion && !dragging) {
                const ease = clamp((idleTime - 6) / 3, 0, 1);
                orbitTarget.theta += dt * 0.05 * ease;
            }

            const orbitRate = reducedMotion ? 2 : 5;

            orbit.theta = damp(orbit.theta, orbitTarget.theta, orbitRate, dt);
            orbit.phi = damp(orbit.phi, orbitTarget.phi, orbitRate, dt);
            orbit.radius = damp(orbit.radius, orbitTarget.radius, orbitRate, dt);

            const look = _look.copy(cameraTarget).lerp(rocket.position, chase * 0.8);
            const radius = (orbit.radius + (reducedMotion ? 0 : Math.sin(t * 0.3) * 0.15)) * (1 - chase * 0.28);
            const sinPhi = Math.sin(orbit.phi);

            camera.position.set(
                look.x + radius * sinPhi * Math.sin(orbit.theta),
                look.y + radius * Math.cos(orbit.phi),
                look.z + radius * sinPhi * Math.cos(orbit.theta)
            );
            camera.lookAt(look);

            if (!reducedMotion) {
                camera.translateX(pointer.x * (isMobile ? 0.25 : 0.75));
                camera.translateY(pointer.y * (isMobile ? 0.15 : 0.45));
                if (shake > 0.001) {
                    camera.position.x += (Math.random() - 0.5) * shake * 0.22;
                    camera.position.y += (Math.random() - 0.5) * shake * 0.22;
                }
                camera.lookAt(look);
            }

            if (Math.abs(camera.fov - (baseFov + fovKick)) > 0.01) {
                camera.fov = baseFov + fovKick;
                camera.updateProjectionMatrix();
            }
            camera.updateMatrixWorld();

            // ----- Cursor in 3D --------------------------------------------

            projectToGround(follow, mouseGround);
            projectToDepth(follow, mouseWorld, camera.position.distanceTo(cameraTarget) * 0.72);

            // Hover test against rocket and monoliths.
            if (frameCount % 3 === 0 && inside && !dragging) {
                const overRocket = pickRocket(targetPointer);
                const hit = overRocket ? null : pickMonolith(targetPointer);
                if (overRocket !== hoveredRocket || hit !== hoveredMonolith) {
                    hoveredRocket = overRocket;
                    hoveredMonolith = hit;
                    if (cursorEl) {
                        cursorEl.classList.toggle('is-hot', overRocket || !!hit);
                        if (cursorLabel) {
                            cursorLabel.textContent = overRocket
                                ? 'CLICK TO LAUNCH'
                                : hit ? hit.userData.name + '  ·  CLICK TO TURN' : '';
                        }
                    }
                }
            }

            // ----- Layered pointer parallax --------------------------------

            if (!reducedMotion) {
                architecture.rotation.y = damp(architecture.rotation.y, pointer.x * 0.28, 3, dt);
                architecture.rotation.x = damp(architecture.rotation.x, -pointer.y * 0.06, 3, dt);

                orbitSystem.rotation.x = damp(orbitSystem.rotation.x, pointer.y * 0.14, 2.5, dt);
                orbitSystem.rotation.z = damp(orbitSystem.rotation.z, -pointer.x * 0.1, 2.5, dt);

                monoliths.rotation.y = Math.sin(t * 0.08) * 0.04 + pointer.x * 0.12;
                networkSystem.rotation.y = Math.sin(t * 0.1) * 0.025 - pointer.x * 0.18;
                networkSystem.position.x = damp(networkSystem.position.x, pointer.x * 0.4, 3, dt);
                horizonGroup.rotation.y = Math.sin(t * 0.06) * 0.02;
                particles.rotation.y = pointer.x * 0.05;

                core.rotation.y += dt * 0.09;
                core.rotation.x = Math.sin(t * 0.17) * 0.025;

                celestialRings.forEach(ring => {
                    ring.rotation.y += ring.userData.spin * dt * (1 + pointerSpeed * 6);
                });
            }

            // ----- Foundation rings react to shock -------------------------

            foundationRings.forEach((ring, i) => {
                const s = 1 + pulse * 0.014 * (i + 1);
                ring.scale.set(s, s, 1);
            });

            // ----- Towers: cursor proximity + shock ripple -----------------

            const shockFront = shock.age * 14;
            const shockFade = Math.exp(-shock.age * 0.8);

            for (const tower of towers) {
                const u = tower.userData;

                tower.getWorldPosition(_v);

                const d = Math.hypot(_v.x - mouseGround.x, _v.z - mouseGround.z);
                const near = THREE.MathUtils.smoothstep(4.2 - d, 0, 4.2) * strength;

                const sd = Math.hypot(_v.x - shock.pos.x, _v.z - shock.pos.z);
                const wave = Math.exp(-Math.pow((sd - shockFront) * 0.6, 2)) * shockFade;

                u.hover = damp(u.hover, Math.max(near, wave), 7, dt);

                tower.position.y = u.baseY +
                    (reducedMotion ? 0 : Math.sin(t * 0.45 + u.phase) * u.amplitude) +
                    u.hover * 0.9;

                u.spineMaterial.emissiveIntensity = 2 + u.hover * 5;
            }

            // ----- Monoliths -----------------------------------------------

            for (const group of monolithGroups) {
                const u = group.userData;

                u.hover = damp(u.hover, group === hoveredMonolith ? 1 : 0, 8, dt);

                group.position.y = u.baseY +
                    (reducedMotion ? 0 : Math.sin(t * 0.45 + u.phase) * u.amplitude) +
                    u.hop;

                group.scale.setScalar(1 + u.hover * 0.2);
                u.material.emissiveIntensity = u.hover * 1.8 + pulse * 0.35 + (u.glow || 0);

                if (!reducedMotion) {
                    u.block.rotation.y += dt * (0.12 + u.hover * 2.2);
                }
            }

            // ----- Network -------------------------------------------------

            for (const node of nodeMeshes) {
                node.scale.setScalar(1 + 0.35 * Math.sin(t * 2 + node.userData.phase) + pulse * 0.8);
            }

            networkLineMaterial.opacity = 0.22 + pointerSpeed * 0.18 + pulse * 0.3;

            if (!reducedMotion) updateSignals(dt);

            // ----- Equaliser ring and trail --------------------------------

            updateBars(t);
            if (!reducedMotion) updateTrail();

            // ----- Lights --------------------------------------------------

            cursorLight.position.lerp(mouseWorld, 1 - Math.exp(-dt * 10));
            cursorLight.intensity = (22 + pointerSpeed * 70 + pulse * 90) * strength;

            amber.emissiveIntensity = 2 + pulse * 3 + rocketState.heat * 4;

            if (!reducedMotion) {
                orangeLight.intensity = 90 + Math.sin(t * 1.2) * 8 + pulse * 120;
                rimLight.intensity = 110 + Math.sin(t * 0.8) * 10;
            }

            // ----- Shader uniforms -----------------------------------------

            particles.worldToLocal(_v.copy(mouseWorld));
            particleMaterial.uniforms.uMouse.value.copy(_v);

            particleMaterial.uniforms.uTime.value = t;
            particleMaterial.uniforms.uStrength.value = strength;

            _v.copy(shock.pos);
            particles.worldToLocal(_v);
            particleMaterial.uniforms.uShock.value.set(_v.x, _v.y, _v.z, shock.age);

            groundMaterial.uniforms.uMouse.value.copy(mouseGround);
            groundMaterial.uniforms.uStrength.value = strength;
            groundMaterial.uniforms.uShock.value.set(shock.pos.x, shock.pos.y, shock.pos.z, shock.age);

            fxPass.uniforms.uTime.value = t;
            fxPass.uniforms.uPointer.value.set(follow.x * 0.5 + 0.5, follow.y * 0.5 + 0.5);
            fxPass.uniforms.uSpeed.value = pointerSpeed * strength;
            fxPass.uniforms.uPulse.value = pulse;

            bloomPass.strength = 0.5 + pulse * 0.8 + pointerSpeed * 0.25 + rocketState.thrust * 0.35;

            // ----- DOM: cursor, text parallax, HUD -------------------------

            if (cursorEl && finePointer) {
                ringPos.x = damp(ringPos.x, cursorPos.x, 14, dt);
                ringPos.y = damp(ringPos.y, cursorPos.y, 14, dt);

                const dot = 'translate3d(' + cursorPos.x.toFixed(1) + 'px,' + cursorPos.y.toFixed(1) + 'px,0)';
                const ring = 'translate3d(' + ringPos.x.toFixed(1) + 'px,' + ringPos.y.toFixed(1) + 'px,0)';

                cursorDot.style.transform = dot;
                cursorRing.style.transform = ring;
                cursorLabel.style.transform = ring;
            }

            if (!reducedMotion && frameCount % 2 === 0) {
                const cx = Math.round(pointer.x * 1000) / 1000;
                const cy = Math.round(pointer.y * 1000) / 1000;

                if (Math.abs(cx - lastCssX) > 0.002 || Math.abs(cy - lastCssY) > 0.002) {
                    root.style.setProperty('--px', cx);
                    root.style.setProperty('--py', cy);
                    lastCssX = cx;
                    lastCssY = cy;
                }
            }

            if (frameCount % 6 === 0 && hudCoord) {
                hudCoord.textContent = 'X ' + fmt(mouseGround.x) + ' Z ' + fmt(mouseGround.z);
            }

            if (frameCount % 60 === 0 && clockElement) {
                const time = new Date();

                clockElement.textContent = [time.getHours(), time.getMinutes(), time.getSeconds()]
                    .map(value => String(value).padStart(2, '0'))
                    .join(':');
            }

            // ----- Render --------------------------------------------------

            composer.render(dt);

            // ----- Adaptive quality ----------------------------------------

            frameAccumulator += dt;
            frameSamples++;
            qualityTimer += dt;

            if (qualityTimer > 2) {
                const average = frameAccumulator / frameSamples;

                if (hudFps) hudFps.textContent = String(Math.round(1 / average)).padStart(2, '0') + ' FPS';

                if (t > 4 && average > 1 / 42 && currentPixelRatio > 0.8) {
                    currentPixelRatio = Math.max(0.8, currentPixelRatio - 0.2);
                    renderer.setPixelRatio(currentPixelRatio);
                    resize();
                }

                qualityTimer = 0;
                frameAccumulator = 0;
                frameSamples = 0;
            }
        }

        // =====================================================================
        // Pause rendering when the hero is off-screen or the tab is hidden
        // =====================================================================

        let visible = true;
        let tabVisible = !document.hidden;

        function updateRunning() {
            const shouldRun = visible && tabVisible && !destroyed;

            if (shouldRun && !running) {
                running = true;
                clock.getDelta();
                renderer.setAnimationLoop(frame);
            } else if (!shouldRun && running) {
                running = false;
                renderer.setAnimationLoop(null);
            }
        }

        const visibilityObserver = new IntersectionObserver(entries => {
            visible = entries[0].isIntersecting;
            updateRunning();
        }, { threshold: 0.02 });

        visibilityObserver.observe(root);

        function onVisibilityChange() {
            tabVisible = !document.hidden;
            updateRunning();
        }

        document.addEventListener('visibilitychange', onVisibilityChange);

        updateRunning();

        // =====================================================================
        // Cleanup
        // =====================================================================

        function cleanup() {
            if (destroyed) return;
            destroyed = true;

            renderer.setAnimationLoop(null);
            resizeObserver.disconnect();
            visibilityObserver.disconnect();

            root.removeEventListener('pointermove', onPointerMove);
            root.removeEventListener('pointerenter', onPointerEnter);
            root.removeEventListener('pointerleave', onPointerLeave);
            mount.removeEventListener('pointerdown', onPointerDown);
            mount.removeEventListener('wheel', onWheel);
            window.removeEventListener('pointerup', onPointerUp);
            window.removeEventListener('pointercancel', onPointerCancel);
            window.removeEventListener('keydown', onKeyDown);
            document.removeEventListener('visibilitychange', onVisibilityChange);

            gsap.killTweensOf([
                orbitTarget,
                cameraTarget,
                core.scale,
                core.rotation,
                orbitSystem.rotation,
                innerCrystal.rotation,
                centralDiamond.rotation,
                ...monolithGroups.map(group => group.rotation),
                ...monolithGroups.map(group => group.userData)
            ]);

            disposeGeometries.forEach(geometry => geometry.dispose());
            disposeMaterials.forEach(material => material.dispose());
            disposeTextures.forEach(texture => texture.dispose());

            bars.dispose();
            struts.dispose();

            bloomPass.dispose();
            fxPass.dispose();
            outputPass.dispose();
            composer.dispose();
            composerTarget.dispose();

            envTexture.dispose();
            pmrem.dispose();

            renderer.dispose();
            renderer.domElement.remove();
        }

        window.addEventListener('pagehide', cleanup, { once: true });
    })();
</script>
@endsection
