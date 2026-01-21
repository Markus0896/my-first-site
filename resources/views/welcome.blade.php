{{-- ============================================== --}}
{{-- СТРАНИЦА СТАРТ КУРСА (для /start)              --}}
{{-- ============================================== --}}

@extends('layouts.app')

@section('title', 'Старт курса - DevStart')

@push('styles')
<style>
    .course-hero {
        background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
        color: white;
        padding: 100px 0;
        margin-top: -76px;
        padding-top: 176px;
    }
    
    .course-module {
        background: white;
        border-radius: 15px;
        border: none;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        overflow: hidden;
    }
    
    .course-module:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.12);
    }
    
    .module-header {
        background: linear-gradient(90deg, #3b82f6, #1d4ed8);
        color: white;
        padding: 20px;
    }
    
    .lesson-item {
        border-bottom: 1px solid #e2e8f0;
        padding: 15px 20px;
        transition: background 0.3s ease;
    }
    
    .lesson-item:hover {
        background: #f8fafc;
    }
    
    .lesson-item.completed {
        background: #f0fdf4;
        border-left: 4px solid #10b981;
    }
    
    .lesson-item.current {
        background: #eff6ff;
        border-left: 4px solid #3b82f6;
    }
    
    .progress-ring {
        width: 120px;
        height: 120px;
    }
    
    .progress-ring circle {
        fill: none;
        stroke-width: 10;
        stroke-linecap: round;
        transform: rotate(-90deg);
        transform-origin: 50% 50%;
    }
    
    .progress-ring-bg {
        stroke: #e2e8f0;
    }
    
    .progress-ring-progress {
        stroke: url(#gradient);
        transition: stroke-dashoffset 1s ease;
    }
</style>
@endpush

@section('content')
    <!-- Заголовок курса -->
    <section class="course-hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <span class="badge bg-white text-primary mb-3 px-3 py-2">
                        <i class="bi bi-mortarboard-fill me-2"></i>Курс для начинающих
                    </span>
                    <h1 class="display-4 fw-bold mb-3">
                        Веб-разработка с Laravel
                    </h1>
                    <p class="lead mb-4 opacity-90">
                        7 дней • 24 урока • Свой первый сайт с регистрацией
                    </p>
                    
                    <div class="d-flex flex-wrap gap-3 align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-clock-fill me-2 opacity-75"></i>
                            <span>15-20 минут/урок</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-check-circle-fill me-2 opacity-75"></i>
                            <span>Практические задания</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-chat-dots-fill me-2 opacity-75"></i>
                            <span>Поддержка в чате</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mt-4 mt-lg-0">
                    <!-- Vue компонент прогресса -->
                    <div id="course-progress" class="text-center">
                        <div class="position-relative d-inline-block">
                            <svg class="progress-ring" viewBox="0 0 120 120">
                                <defs>
                                    <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="0%">
                                        <stop offset="0%" stop-color="#3b82f6" />
                                        <stop offset="100%" stop-color="#8b5cf6" />
                                    </linearGradient>
                                </defs>
                                <circle class="progress-ring-bg" cx="60" cy="60" r="50" />
                                <circle class="progress-ring-progress" 
                                        cx="60" 
                                        cy="60" 
                                        r="50"
                                        :stroke-dasharray="circumference"
                                        :stroke-dashoffset="dashOffset" />
                            </svg>
                            <div class="position-absolute top-50 start-50 translate-middle text-center">
                                <div class="display-6 fw-bold">@{{ progress }}%</div>
                                <small class="text-muted">завершено</small>
                            </div>
                        </div>
                        
                        <div class="mt-3">
                            <button @click="updateProgress" class="btn btn-outline-light btn-sm">
                                <i class="bi bi-arrow-clockwise me-1"></i> Обновить прогресс
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Модули курса -->
    <section class="py-5">
        <div class="container">
            <h2 class="fw-bold mb-5">Программа курса</h2>
            
            <div id="course-modules">
                <!-- Модуль 1 -->
                <div class="course-module mb-4">
                    <div class="module-header">
                        <h4 class="mb-0">
                            <i class="bi bi-1-circle me-2"></i>День 1: Знакомство с окружением
                        </h4>
                    </div>
                    <div class="module-body">
                        <div v-for="lesson in modules[0].lessons" 
                             :key="lesson.id"
                             :class="['lesson-item', lesson.status]"
                             @click="toggleLessonStatus(0, lesson.id)">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i :class="['me-3', lesson.icon]"></i>
                                    <span class="fw-medium">@{{ lesson.title }}</span>
                                </div>
                                <div>
                                    <span class="badge bg-secondary me-2">@{{ lesson.duration }} мин</span>
                                    <i v-if="lesson.status === 'completed'" class="bi bi-check-circle-fill text-success"></i>
                                    <i v-else-if="lesson.status === 'current'" class="bi bi-play-circle-fill text-primary"></i>
                                    <i v-else class="bi bi-circle text-muted"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Модуль 2 -->
                <div class="course-module mb-4">
                    <div class="module-header">
                        <h4 class="mb-0">
                            <i class="bi bi-2-circle me-2"></i>День 2: Первый проект на Laravel
                        </h4>
                    </div>
                    <div class="module-body">
                        <div v-for="lesson in modules[1].lessons" 
                             :key="lesson.id"
                             :class="['lesson-item', lesson.status]"
                             @click="toggleLessonStatus(1, lesson.id)">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i :class="['me-3', lesson.icon]"></i>
                                    <span class="fw-medium">@{{ lesson.title }}</span>
                                </div>
                                <div>
                                    <span class="badge bg-secondary me-2">@{{ lesson.duration }} мин</span>
                                    <i v-if="lesson.status === 'completed'" class="bi bi-check-circle-fill text-success"></i>
                                    <i v-else-if="lesson.status === 'current'" class="bi bi-play-circle-fill text-primary"></i>
                                    <i v-else class="bi bi-circle text-muted"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Модуль 3 -->
                <div class="course-module mb-4">
                    <div class="module-header">
                        <h4 class="mb-0">
                            <i class="bi bi-3-circle me-2"></i>День 3: Работа с базой данных
                        </h4>
                    </div>
                    <div class="module-body">
                        <div v-for="lesson in modules[2].lessons" 
                             :key="lesson.id"
                             :class="['lesson-item', lesson.status]"
                             @click="toggleLessonStatus(2, lesson.id)">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i :class="['me-3', lesson.icon]"></i>
                                    <span class="fw-medium">@{{ lesson.title }}</span>
                                </div>
                                <div>
                                    <span class="badge bg-secondary me-2">@{{ lesson.duration }} мин</span>
                                    <i v-if="lesson.status === 'completed'" class="bi bi-check-circle-fill text-success"></i>
                                    <i v-else-if="lesson.status === 'current'" class="bi bi-play-circle-fill text-primary"></i>
                                    <i v-else class="bi bi-circle text-muted"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Статистика курса -->
                <div class="row mt-5">
                    <div class="col-md-3 text-center">
                        <div class="display-6 fw-bold text-primary">@{{ totalLessons }}</div>
                        <small class="text-muted">Всего уроков</small>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="display-6 fw-bold text-success">@{{ completedLessons }}</div>
                        <small class="text-muted">Завершено</small>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="display-6 fw-bold text-warning">@{{ totalDuration }}</div>
                        <small class="text-muted">Минут обучения</small>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="display-6 fw-bold text-info">@{{ modules.length }}</div>
                        <small class="text-muted">Модулей</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Призыв к действию -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <div class="p-5 rounded-4 shadow" style="background: white;">
                        <i class="bi bi-play-btn-fill display-1 text-primary mb-4"></i>
                        <h2 class="fw-bold mb-3">Начни первый урок прямо сейчас!</h2>
                        <p class="lead mb-4">
                            Первые 3 урока бесплатно. Никакой регистрации не требуется.
                        </p>
                        
                        <div class="d-flex justify-content-center gap-3">
                            <a href="#lesson-1" class="btn btn-primary btn-lg px-4">
                                <i class="bi bi-play-fill me-2"></i>Начать урок 1
                            </a>
                            <a href="/register" class="btn btn-outline-primary btn-lg px-4">
                                <i class="bi bi-person-plus me-2"></i>Записаться на курс
                            </a>
                        </div>
                        
                        <p class="text-muted mt-4 mb-0">
                            <i class="bi bi-unlock-fill me-1"></i> Бесплатный доступ к первым 3 урокам
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    // Vue приложение для курса
    const { createApp } = Vue;
    
    createApp({
        data() {
            return {
                modules: [
                    {
                        title: 'День 1: Знакомство с окружением',
                        lessons: [
                            { id: 1, title: 'Установка PHP и Composer', duration: 15, icon: 'bi bi-download', status: 'completed' },
                            { id: 2, title: 'Установка Laravel', duration: 10, icon: 'bi bi-gear', status: 'completed' },
                            { id: 3, title: 'Структура проекта Laravel', duration: 20, icon: 'bi bi-folder', status: 'current' },
                            { id: 4, title: 'Запуск первого сервера', duration: 12, icon: 'bi bi-play-circle', status: 'pending' }
                        ]
                    },
                    {
                        title: 'День 2: Первый проект на Laravel',
                        lessons: [
                            { id: 5, title: 'Создание главной страницы', duration: 18, icon: 'bi bi-house', status: 'pending' },
                            { id: 6, title: 'Работа с Blade шаблонами', duration: 25, icon: 'bi bi-file-code', status: 'pending' },
                            { id: 7, title: 'Добавление Bootstrap', duration: 15, icon: 'bi bi-bootstrap', status: 'pending' },
                            { id: 8, title: 'Создание навигации', duration: 20, icon: 'bi bi-menu-button', status: 'pending' }
                        ]
                    },
                    {
                        title: 'День 3: Работа с базой данных',
                        lessons: [
                            { id: 9, title: 'Настройка базы данных', duration: 15, icon: 'bi bi-database', status: 'pending' },
                            { id: 10, title: 'Миграции в Laravel', duration: 20, icon: 'bi bi-arrow-repeat', status: 'pending' },
                            { id: 11, title: 'Модели Eloquent', duration: 25, icon: 'bi bi-diagram-3', status: 'pending' },
                            { id: 12, title: 'CRUD операции', duration: 30, icon: 'bi bi-plus-circle', status: 'pending' }
                        ]
                    }
                ],
                radius: 50,
                progress: 25
            }
        },
        computed: {
            // Математика для прогресс-круга
            circumference() {
                return 2 * Math.PI * this.radius;
            },
            dashOffset() {
                return this.circumference * (1 - this.progress / 100);
            },
            // Статистика
            totalLessons() {
                return this.modules.reduce((total, module) => total + module.lessons.length, 0);
            },
            completedLessons() {
                return this.modules.reduce((total, module) => {
                    return total + module.lessons.filter(lesson => lesson.status === 'completed').length;
                }, 0);
            },
            totalDuration() {
                return this.modules.reduce((total, module) => {
                    return total + module.lessons.reduce((sum, lesson) => sum + lesson.duration, 0);
                }, 0);
            }
        },
        methods: {
            // Обновление прогресса
            updateProgress() {
                const completed = this.completedLessons;
                const total = this.totalLessons;
                this.progress = Math.round((completed / total) * 100);
                
                // Анимация
                document.querySelector('.progress-ring-progress').classList.add('animate__animated', 'animate__pulse');
                setTimeout(() => {
                    document.querySelector('.progress-ring-progress').classList.remove('animate__animated', 'animate__pulse');
                }, 1000);
            },
            // Переключение статуса урока
            toggleLessonStatus(moduleIndex, lessonId) {
                const module = this.modules[moduleIndex];
                const lesson = module.lessons.find(l => l.id === lessonId);
                
                if (lesson.status === 'completed') {
                    lesson.status = 'pending';
                } else {
                    lesson.status = 'completed';
                    // Если есть следующий урок, делаем его текущим
                    const nextLesson = module.lessons.find(l => l.id === lessonId + 1);
                    if (nextLesson && nextLesson.status === 'pending') {
                        nextLesson.status = 'current';
                    }
                }
                
                // Обновляем прогресс
                this.updateProgress();
            }
        },
        mounted() {
            this.updateProgress();
        }
    }).mount('#course-modules');
    
    // Отдельное Vue приложение для прогресс-круга
    const { createApp: createProgressApp } = Vue;
    createProgressApp({
        data() {
            return {
                progress: 25,
                radius: 50
            }
        },
        computed: {
            circumference() {
                return 2 * Math.PI * this.radius;
            },
            dashOffset() {
                return this.circumference * (1 - this.progress / 100);
            }
        },
        methods: {
            updateProgress() {
                // Симуляция обновления прогресса
                this.progress = Math.min(this.progress + 10, 100);
                
                // Анимация
                document.querySelector('.progress-ring-progress').classList.add('animate__animated', 'animate__pulse');
                setTimeout(() => {
                    document.querySelector('.progress-ring-progress').classList.remove('animate__animated', 'animate__pulse');
                }, 1000);
            }
        }
    }).mount('#course-progress');
</script>
@endpush    