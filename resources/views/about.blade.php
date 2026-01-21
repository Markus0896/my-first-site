{{-- ============================================== --}}
{{-- СТРАНИЦА О НАС: используем общий layout        --}}
{{-- ============================================== --}}

@extends('layouts.app')

@section('title', 'О нас - DevStart проект')

@push('styles')
<style>
    /* Специфичные стили для страницы О нас */
    .about-hero {
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        color: white;
        padding: 100px 0;
        margin-top: -76px;
        padding-top: 176px;
    }
    
    .feature-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(45deg, var(--primary), var(--secondary));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        color: white;
        font-size: 30px;
    }
    
    .team-member {
        transition: transform 0.3s ease;
    }
    
    .team-member:hover {
        transform: translateY(-10px);
    }
    
    .team-member img {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border: 5px solid white;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        text-align: center;
        border: none;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    
    .stat-number {
        font-size: 2.5rem;
        font-weight: bold;
        background: linear-gradient(45deg, var(--primary), var(--accent));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
</style>
@endpush

@section('content')
    <!-- Герой секция -->
    <section class="about-hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-3 fw-bold mb-4 animate__animated animate__fadeInDown">О проекте DevStart</h1>
                    <p class="lead mb-4 animate__animated animate__fadeInUp">Мы создаем удивительные веб-приложения с использованием современных технологий и креативного подхода.</p>
                    <a href="/start" class="btn btn-light btn-lg animate__animated animate__pulse animate__infinite">
                        <i class="bi bi-arrow-right-circle me-2"></i>Начать обучение
                    </a>
                </div>
                <div class="col-lg-6 text-center">
                    <img src="https://cdn.pixabay.com/photo/2018/05/18/15/30/web-design-3411373_1280.jpg" 
                         class="img-fluid rounded shadow-lg animate__animated animate__fadeInRight" 
                         alt="Веб-дизайн" 
                         style="max-height: 400px;">
                </div>
            </div>
        </div>
    </section>

    <!-- Статистика (Vue компонент) -->
    <section class="py-5">
        <div class="container">
            <div id="stats-demo">
                <h2 class="text-center fw-bold mb-5">Наша статистика в реальном времени</h2>
                
                <div class="row g-4">
                    <div class="col-md-3" v-for="stat in stats" :key="stat.id">
                        <div class="stat-card">
                            <div class="feature-icon">
                                <i :class="stat.icon"></i>
                            </div>
                            <div class="stat-number">@{{ stat.value }}</div>
                            <p class="text-muted mb-0">@{{ stat.label }}</p>
                            <small class="text-muted" v-if="stat.increment > 0">
                                <i class="bi bi-arrow-up text-success"></i> +@{{ stat.increment }}/день
                            </small>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <button @click="updateStats" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-arrow-clockwise"></i> Обновить статистику
                    </button>
                    <small class="d-block text-muted mt-2">
                        Данные обновляются в реальном времени с помощью Vue.js
                    </small>
                </div>
            </div>
        </div>
    </section>

    <!-- О нас -->
    <section class="bg-light py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <h2 class="text-center mb-5">Кто мы такие?</h2>
                    
                    <div class="card p-4 mb-4 shadow-sm">
                        <div class="row align-items-center">
                            <div class="col-md-3 text-center">
                                <div class="feature-icon">
                                    <i class="bi bi-heart-fill"></i>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <h3>Наша миссия</h3>
                                <p>Мы стремимся сделать веб-разработку доступной для каждого. Наш проект создан для того, чтобы помочь новичкам сделать свои первые шаги в мире программирования. Мы верим, что каждый может научиться создавать сайты, независимо от возраста или опыта.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Особенности -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Почему выбирают нас?</h2>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 p-4 text-center shadow-sm">
                        <div class="feature-icon">
                            <i class="bi bi-lightning-charge"></i>
                        </div>
                        <h4>Быстро</h4>
                        <p>Наши сайты загружаются мгновенно благодаря оптимизации и современным технологиям.</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card h-100 p-4 text-center shadow-sm">
                        <div class="feature-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h4>Безопасно</h4>
                        <p>Максимальная защита данных пользователей и современные методы шифрования.</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card h-100 p-4 text-center shadow-sm">
                        <div class="feature-icon">
                            <i class="bi bi-phone"></i>
                        </div>
                        <h4>Адаптивно</h4>
                        <p>Идеальное отображение на любых устройствах: от смартфонов до desktop компьютеров.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Команда -->
    <section class="bg-light py-5">
        <div class="container">
            <h2 class="text-center mb-5">Наша команда</h2>
            
            <div class="row g-4 justify-content-center">
                <div class="col-md-3">
                    <div class="card text-center team-member p-3">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" class="card-img-top rounded-circle mx-auto" alt="Марк">
                        <div class="card-body">
                            <h5 class="card-title">Марк</h5>
                            <p class="text-muted">Основатель</p>
                            <p>Создатель этого проекта и главный энтузиаст.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card text-center team-member p-3">
                        <img src="https://randomuser.me/api/portraits/women/44.jpg" class="card-img-top rounded-circle mx-auto" alt="Анна">
                        <div class="card-body">
                            <h5 class="card-title">Анна</h5>
                            <p class="text-muted">Дизайнер</p>
                            <p>Создает красивые и удобные интерфейсы.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card text-center team-member p-3">
                        <img src="https://randomuser.me/api/portraits/men/67.jpg" class="card-img-top rounded-circle mx-auto" alt="Иван">
                        <div class="card-body">
                            <h5 class="card-title">Иван</h5>
                            <p class="text-muted">Разработчик</p>
                            <p>Пишет чистый и эффективный код.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    // Vue приложение для статистики на странице О нас
    const { createApp } = Vue;
    createApp({
        data() {
            return {
                stats: [
                    { id: 1, label: 'Учеников', value: 1234, icon: 'bi bi-people-fill', increment: 5 },
                    { id: 2, label: 'Часов обучения', value: 5678, icon: 'bi bi-clock-fill', increment: 25 },
                    { id: 3, label: 'Завершенных проектов', value: 89, icon: 'bi bi-check-circle-fill', increment: 2 },
                    { id: 4, label: 'Счастливых отзывов', value: 95, icon: 'bi bi-emoji-smile-fill', increment: 1 }
                ]
            }
        },
        methods: {
            updateStats() {
                this.stats.forEach(stat => {
                    // Увеличиваем значения на случайное число
                    const increment = Math.floor(Math.random() * 10) + 1;
                    stat.value += increment;
                    stat.increment = increment;
                });
                
                // Анимация обновления
                this.$el.querySelectorAll('.stat-number').forEach(el => {
                    el.classList.add('animate__animated', 'animate__pulse');
                    setTimeout(() => {
                        el.classList.remove('animate__animated', 'animate__pulse');
                    }, 1000);
                });
            }
        },
        mounted() {
            // Автоматическое обновление статистики каждые 10 секунд
            setInterval(() => {
                this.updateStats();
            }, 10000);
        }
    }).mount('#stats-demo');
</script>
@endpush