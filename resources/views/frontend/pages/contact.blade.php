
@extends('layouts.app')

@section('title', 'Contact')
@section('description', 'Contact me about software projects, collaboration, and opportunities.')

@section('content')
<section class="page">
    <div class="wrap">
        <span class="eyebrow">Let's connect</span>
        <h1 class="heading">Have an idea? Let's talk<span style="color:var(--accent)">.</span></h1>
        <p class="lead">
            Have a project idea, collaboration opportunity, or question?
            Send me a message.
        </p>

        <div class="two-grid">
            <div>
                <div class="card">
                    <div class="icon-box">✉️</div>
                    <h2 class="section-heading">Get in touch</h2>
                    <p>
                        I'm interested in discussing software development,
                        learning opportunities, and interesting projects.
                    </p>

                    <div style="margin-top:25px">
                        <p><strong>Email</strong></p>
                        <a href="mailto:roshangauchan.thakali01@gmail.com"
                           style="color:var(--accent)">
                            roshangauchan.thakali01@gmail.com
                        </a>
                    </div>

                    <div style="margin-top:20px">
                        <p><strong>GitHub</strong></p>
                        <a href="https://github.com/thakalihone-beep"
                           target="_blank" rel="noopener noreferrer"
                           style="color:var(--accent)">
                            thakalihone-beep (Roshan Gauchan) ↗
                        </a>
                    </div>

                    <div style="margin-top:20px">
                        <p><strong>LinkedIn</strong></p>
                        <a href="https://www.linkedin.com/in/roshan-gauchan-33381b417"
                           target="_blank" rel="noopener noreferrer"
                           style="color:var(--accent)">
                            Connect on LinkedIn ↗
                        </a>
                    </div>
                </div>
            </div>

            <div class="card">
                <h2 class="section-heading">Send a message</h2>

                @if (session('status'))
                    <p class="muted" role="status">{{ session('status') }}</p>
                @endif

                @if ($errors->any())
                    <p class="muted" role="alert">Please correct the highlighted fields and try again.</p>
                @endif

                <form action="{{ route('contact.store') }}" method="post">
                    @csrf
                    <div class="field">
                        <label for="name">Your name</label>
                           <input id="name" name="name" type="text"
                               value="{{ old('name') }}" maxlength="255"
                               autocomplete="name" required>
                        @error('name') <small class="muted">{{ $message }}</small> @enderror
                    </div>

                    <div class="field">
                        <label for="email">Email address</label>
                        <input id="email" name="email" type="email"
                               value="{{ old('email') }}" maxlength="255"
                               autocomplete="email" placeholder="you@example.com" required>
                        @error('email') <small class="muted">{{ $message }}</small> @enderror
                    </div>

                    <div class="field">
                        <label for="subject">Subject</label>
                        <input id="subject" name="subject" type="text"
                               value="{{ old('subject') }}" maxlength="255"
                               placeholder="What is this about?" required>
                        @error('subject') <small class="muted">{{ $message }}</small> @enderror
                    </div>

                    <div class="field">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" maxlength="5000"
                                  placeholder="Tell me about your idea..." required>{{ old('message') }}</textarea>
                        @error('message') <small class="muted">{{ $message }}</small> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Send Message ↗
                    </button>

                </form>
            </div>
        </div>
    </div>
</section>
@endsection
