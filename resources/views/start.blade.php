{{-- ============================================== --}}
{{-- СТРАНИЦА СТАРТ: используем общий layout        --}}
{{-- ============================================== --}}

@extends('layouts.app')

@section('title', 'Старт - Начни свой путь в разработке')

{{-- Добавляем специфичные для этой страницы стили --}}
@push('styles')
<style>
    /* Специфичные стили для страницы Старт */
    .start-hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 100px 0;
        clip-path: polygon(0 0, 100% 0, 100% 85%, 0 100%);
        margin-top: -76px; /* Компенсируем фиксированную шапку */
        padding-top: 176px;
    }
    
    .start-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
        background-size: 50px 50px;
        animation: float 20s linear infinite;
    }
    
    @keyframes float {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    .step-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        height: 100%;
        border: none;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        overflow: hidden;
    }
    
    .step-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 5px;
        height: 100%;
        background: linear-gradient(to bottom, var(--primary), var(--accent));
        transition: width 0.3s ease;
    }
    
    .step-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }
    
    .step-card:hover::before {
        width: 100%;
        opacity: 0.05;
    }
    
    .step-number {
        width: 60px;
        height: 60px;
        background: linear-gradient(45deg, var(--primary), var(--secondary));
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 20px;
        box-shadow: 0 5px 15px rgba(99, 102, 241, 0.3);
    }
    
    .timer {
        font-family: 'Courier New', monospace;
        font-size: 2.5rem;
        font-weight: bold;
        background: linear-gradient(45deg, var(--primary), var(--accent));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    
    .code-block {
        background: #1e1e1e;
        color: #d4d4d4;
        border-radius: 10px;
        padding: 20px;
        font-family: 'Courier New', monospace;
        overflow-x: auto;
    }
    
    .code-keyword { color: #569cd6; }
    .code-string { color: #ce9178; }
    .code-comment { color: #6a9955; }
    .code-function { color: #dcdcaa; }
</style>
@endpush

{{-- Основной контент страницы --}}
@section('content')
    <!-- Герой секция -->
    <section class="start-hero position-relative overflow-hidden">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 animate__animated animate__fadeInLeft">
                    <span class="badge bg-white text-primary mb-3 px-3 py-2">
                        <i class="bi bi-stars me-1"></i>Для начинающих
                    </span>
                    <h1 class="display-3 fw-bold mb-4">Твой путь в <span class="text-warning">веб-разработке</span> начинается здесь</h1>
                    <p class="lead mb-4 opacity-90">Пошаговый гид от нуля до первого сайта. Никакой сложной теории — только практика и результат!</p>
                    <div class="d-flex gap-3">
                        <a href="/register" class="btn btn-glow animate__animated animate__pulse animate__infinite">
                            <i class="bi bi-play-circle me-2"></i>Начать сейчас
                        </a>
                        <a href="#steps" class="btn btn-outline-light">
                            <i class="bi bi-camera-video me-2"></i>Смотреть видео
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 animate__animated animate__fadeInRight">
                    <div class="position-relative">
                        <div class="code-block">
                            <span class="code-keyword">&lt;?php</span><br>
                            <span class="code-comment">// Твой первый код:</span><br>
                            <span class="code-function">echo</span> <span class="code-string">'Привет, мир! 🚀'</span>;<br>
                            <span class="code-comment">// Результат: Привет, мир! 🚀</span>
                        </div>
                        <div class="position-absolute top-0 end-0 mt-3 me-3">
                            <span class="badge bg-success px-3 py-2">
                                <i class="bi bi-check-circle me-1"></i>Работает!
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Прогресс (Vue компонент) -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center">
                    <h2 class="fw-bold mb-3">Твой прогресс за сегодня</h2>
                    <p>Начни с малого — закончи большим проектом!</p>
                    
                    <!-- Vue компонент прогресса -->
                    <div id="progress-demo">
                        <div class="progress mb-3" style="height: 20px;">
                            <div class="progress-bar" :style="progressStyle" role="progressbar">
                                <span class="visually-hidden">@{{ progress }}% завершено</span>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between text-muted small mb-4">
                            <span>Начало</span>
                            <span>@{{ progress }}% - @{{ progressText }}</span>
                            <span>Готовый сайт</span>
                        </div>
                        
                        <div class="d-flex justify-content-center gap-3 mb-4">
                            <button @click="increaseProgress" class="btn btn-sm btn-outline-success">
                                <i class="bi bi-plus-lg"></i> Увеличить прогресс
                            </button>
                            <button @click="progress = 0" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-arrow-clockwise"></i> Сбросить
                            </button>
                        </div>
                        
                        <div class="mt-4">
                            <h4 class="timer">@{{ formattedTime }}</h4>
                            <p class="text-muted">Время изучения сегодня</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Этапы обучения -->
    <section class="bg-light py-5" id="steps">
        <div class="container">
            <h2 class="text-center fw-bold mb-5">5 шагов к твоему первому сайту</h2>
            
            <div class="row g-4">
                <!-- Этапы 1-5 (оставляем как было, но удаляем дублирующиеся стили) -->
                <div class="col-md-4">
                    <div class="step-card animate__animated">
                        <div class="step-number">1</div>
                        <h4 class="fw-bold">Установка</h4>
                        <p>Скачай и настрой всё необходимое ПО за 15 минут</p>
                        <ul class="list-unstyled">
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>VS Code</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>Git</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>Localhost</li>
                        </ul>
                        <button class="btn btn-sm btn-outline-primary mt-3">
                            <i class="bi bi-download me-1"></i>Инструкция
                        </button>
                    </div>
                </div>
                
                <!-- ... остальные этапы 2-5 оставляем как были ... -->
                <div class="col-md-4">
                    <div class="step-card animate__animated">
                        <div class="step-number">2</div>
                        <h4 class="fw-bold">Первый проект</h4>
                        <p>Создай свой первый Laravel проект</p>
                        <div class="code-block small">
                            <span class="code-comment">$ composer create-project...</span><br>
                            <span class="code-comment">$ php artisan serve</span>
                        </div>
                        <button class="btn btn-sm btn-outline-primary mt-3">
                            <i class="bi bi-terminal me-1"></i>Команды
                        </button>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="step-card animate__animated">
                        <div class="step-number">3</div>
                        <h4 class="fw-bold">Регистрация</h4>
                        <p>Добавь форму регистрации за 5 минут</p>
                        <div class="text-center">
                            <i class="bi bi-person-plus-fill" style="font-size: 2rem; color: #6366f1;"></i>
                        </div>
                        <a href="/register" class="btn btn-sm btn-outline-primary mt-3">
                            <i class="bi bi-person-plus me-1"></i>Попробовать
                        </a>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="step-card animate__animated">
                        <div class="step-number">4</div>
                        <h4 class="fw-bold">Дизайн</h4>
                        <p>Сделай красивый интерфейс с Bootstrap</p>
                        <div class="d-flex gap-2">
                            <span class="badge bg-primary">CSS</span>
                            <span class="badge bg-info">Bootstrap</span>
                            <span class="badge bg-warning">JavaScript</span>
                        </div>
                        <a href="/about" class="btn btn-sm btn-outline-primary mt-3">
                            <i class="bi bi-palette me-1"></i>Примеры
                        </a>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="step-card animate__animated">
                        <div class="step-number">5</div>
                        <h4 class="fw-bold">Деплой</h4>
                        <p>Опубликуй сайт в интернете бесплатно</p>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-globe me-2" style="font-size: 1.5rem; color: #6366f1;"></i>
                            <span>https://<strong>твой-сайт</strong>.com</span>
                        </div>
                        <button class="btn btn-sm btn-outline-primary mt-3">
                            <i class="bi bi-cloud-upload me-1"></i>Опубликовать
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Призыв к действию -->
    <section class="py-5" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <div class="p-5 rounded-4 shadow" style="background: white;">
                        <i class="bi bi-trophy-fill display-1 mb-4" style="color: #f59e0b;"></i>
                        <h2 class="fw-bold mb-3">Начни прямо сейчас!</h2>
                        <p class="lead mb-4">Уже <span class="fw-bold text-primary">1,234</span> человек начали свой путь в разработке с этого руководства.</p>
                        
                        <div class="d-flex justify-content-center gap-3">
                            <a href="/register" class="btn btn-glow btn-lg">
                                <i class="bi bi-rocket-takeoff me-2"></i>Бесплатный старт
                            </a>
                            <a href="/about" class="btn btn-outline-primary btn-lg">
                                <i class="bi bi-info-circle me-2"></i>Подробнее
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

{{-- Специфичные скрипты для этой страницы --}}
@push('scripts')
<script>
    // Vue приложение для прогресса на странице Старт
    const { createApp } = Vue;
    createApp({
        data() {
            return {
                progress: 25,
                secondsStudied: 0,
                progressTexts: [
                    'Установка окружения',
                    'Первый проект Laravel',
                    'Добавление регистрации',
                    'Сайт в интернете!'
                ]
            }
        },
        computed: {
            progressStyle() {
                const gradient = this.progress < 50 ? '#4ade80' : this.progress < 75 ? '#3b82f6' : '#8b5cf6';
                return `width: ${this.progress}%; background: linear-gradient(90deg, #6366f1, ${gradient}); transition: width 0.5s ease;`;
            },
            progressText() {
                const index = Math.min(Math.floor(this.progress / 25), 3);
                return this.progressTexts[index];
            },
            formattedTime() {
                const hours = Math.floor(this.secondsStudied / 3600).toString().padStart(2, '0');
                const minutes = Math.floor((this.secondsStudied % 3600) / 60).toString().padStart(2, '0');
                const seconds = (this.secondsStudied % 60).toString().padStart(2, '0');
                return `${hours}:${minutes}:${seconds}`;
            }
        },
        methods: {
            increaseProgress() {
                if (this.progress < 100) {
                    this.progress += 25;
                }
            }
        },
        mounted() {
            // Таймер изучения
            setInterval(() => {
                this.secondsStudied++;
            }, 1000);
            
            // Анимация карточек при скролле
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        setTimeout(() => {
                            entry.target.classList.add('animate__fadeInUp');
                        }, index * 200);
                    }
                });
            }, { threshold: 0.1 });
            
            document.querySelectorAll('.step-card').forEach(card => {
                observer.observe(card);
            });
        }
    }).mount('#progress-demo');
</script>
@endpush