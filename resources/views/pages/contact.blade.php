@extends('layouts.app')

@section('title', 'Contact - Excellence Afrik')
@section('meta_description', 'Contactez l\'équipe d\'Excellence Afrik pour vos questions, partenariats ou propositions de collaboration')

@section('page_title', 'Contactez-nous')
@section('page_subtitle', 'Nous sommes à votre écoute pour toute question ou collaboration')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-10">


            <main>
                <!-- hero-area start -->
                <div class="page-banner-area">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-bar text-center pt-60 pb-60">
                                    <h1>NOUS CONTACTER</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- hero-area end -->

                <!-- blog-area start -->
                <div class="contact-area pt-110 pb-90">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-5 col-lg-6">
                                <div class="contact-info mb-30">
                                    <h2>NOUS CONTACTER</h2>
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="contact-meta mb-30">
                                                <div class="contact-meta-info">
                                                    <h4>Téléphones</h4>
                                                    <p>+225 07 10 83 43 45 </p>
                                                    <p>+225 05 96 79 08 02 </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="contact-meta mb-30">
                                                <div class="contact-meta-info">
                                                    <h4>E-mail</h4>
                                                    <p>contact@excellenceafrik.com;</p>
                                                    <p>info@excellenceafrik.com</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="contact-meta">
                                                <div class="contact-meta-info">
                                                    <h4>Adresse</h4>
                                                    <p>Cocody, Angré Cité Soleil 3, Villa 105</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-7 col-lg-6">
                                <div class="contact-form mb-30">
                                    <h3>Avez vous une question ?</h3>

                                    @if(session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif

                                    @if($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <form action="{{ route('pages.contact.send') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <input name="name" type="text" placeholder="Nom">
                                            </div>
                                            <div class="col-xl-6">
                                                <input name="email" type="email" placeholder="Email">
                                            </div>
                                            <div class="col-xl-12">
                                                <input name="subject" type="text" placeholder="Objet">
                                            </div>
                                            <div class="col-xl-12">
                                                <textarea name="message" id="mesage" cols="30" rows="10" placeholder="Message"></textarea>
                                                <button class="btn brand-btn" type="submit">Envoyer</button>
                                            </div>
                                        </div>
                                    </form>
                                    <p class="ajax-response"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </main>

        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.page-title-bar {
    background: linear-gradient(to right, #996633, #f7c807);
}
.page-title-bar h1 {
    color: #fff;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
}
.contact-hero {
    padding: 3rem 0;
}

.contact-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    color: var(--bs-primary);
}

.contact-description {
    font-size: 1.1rem;
    line-height: 1.6;
    color: var(--bs-gray-600);
    margin-bottom: 2rem;
}

.contact-stats {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-weight: 500;
}

.contact-form-wrapper {
    background: white;
    padding: 2.5rem;
    border-radius: 1.5rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.form-title {
    font-size: 2rem;
    font-weight: 600;
    margin-bottom: 2rem;
    color: var(--bs-dark);
}

.form-control, .form-select {
    border-radius: 0.5rem;
    border: 2px solid #f1f3f4;
    padding: 0.75rem 1rem;
    transition: border-color 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: var(--bs-primary);
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

.contact-info {
    background: #000;
    padding: 2.5rem;
    border-radius: 1.5rem;
    height: fit-content;
}

.contact-info h2 {
    color: #D4AF37; /* Gold color */
}

.contact-info h4,
.contact-info p {
    color: #fff; /* White color */
}

.info-title {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 2rem;
    color: var(--bs-dark);
}

.info-item {
    display: flex;
    gap: 1rem;
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid #dee2e6;
}

.info-item:last-of-type {
    border-bottom: none;
    margin-bottom: 2rem;
}

.info-icon {
    width: 50px;
    height: 50px;
    background: var(--bs-primary);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.info-content h4 {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: var(--bs-dark);
}

.info-content p {
    margin: 0;
    color: var(--bs-gray-600);
    font-size: 0.95rem;
}

.social-links h4 {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 1rem;
    color: var(--bs-dark);
}

.social-icons {
    display: flex;
    gap: 1rem;
}

.social-icon {
    width: 40px;
    height: 40px;
    background: var(--bs-primary);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.3s ease;
}

.social-icon:hover {
    background: var(--bs-dark);
    color: white;
    transform: translateY(-2px);
}

@media (max-width: 768px) {
    .contact-title {
        font-size: 2rem;
    }

    .contact-stats {
        margin-top: 2rem;
    }

    .contact-form-wrapper,
    .contact-info {
        padding: 2rem;
    }
}
</style>
@endpush
