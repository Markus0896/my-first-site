{{-- ============================================== --}}
{{-- ЛИЧНЫЙ КАБИНЕТ (Dashboard)                     --}}
{{-- ============================================== --}}

@extends('layouts.app')

@section('title', 'Личный кабинет - DevStart')

@push('styles')
<style>
    /* Стили для дашборда */
    .dashboard-hero {
        background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
        color: white;
        padding: 60px 0;
        margin-top: -76px;
        padding-top: 136px;
        border-radius: 0 0 20px 20px;
    }
    
    .user-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        border: 4px solid white;
        object-fit: cover;
        background: linear-gradient(135deg, #667eea, #764ba2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
        color: white;
        font-weight: bold;
    }
    
    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        border: none;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    
    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 15px;
    }
    
    .progress-ring-dashboard {
        width: 100px;
        height: 100px;
    }
    
    .progress-ring-dashboard circle {
        fill: none;
        stroke-width: 8;
        stroke-linecap: round;
        transform: rotate(-90deg);
        transform-origin: 50% 50%;
    }
    
    .course-card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .course-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.12);
    }
    
    .course-progress {
        height: 6px;
        border-radius: 3px;
        overflow: hidden;
        background: #e2e8f0;
    }
    
    .course-progress-bar {
        height: 100%;
        border-radius: 3px;
        transition: width 0.5s ease;
    }
    
    .quick-action {
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        color: #64748b;
        transition: all 0.3s ease;
        cursor: pointer;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    
    .quick-action:hover {
        border-color: #6366f1;
        background: #f8fafc;
        color: #6366f1;
    }
    
    .badge-pill {
        border-radius: 20px;
        padding: 5px 12px;
        font-size: 0.75rem;
    }
    
    /* Анимации */
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    
    .pulse-animation {
        animation: pulse 2s infinite;
    }
</style>
@endpush

@section('content')
    <!-- Хиро секция дашборда -->
    <section class="dashboard-hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-auto">
                    <div class="user-avatar">
                        {{-- Первая буква имени пользователя --}}
                        @auth
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        @else
                            U
                        @endauth
                    </div>
                </div>
                <div class="col">
                    <h1 class="h2 fw-bold mb-2">
                        @auth
                            Добро пожаловать, {{ Auth::user()->name }}!
                        @else
                            Добро пожаловать!
                        @endauth
                    </h1>
                    <p class="mb-0 opacity-90">
                        <i class="bi bi-calendar-check me-1"></i>
                        {{ now()->format('d.m.Y') }} • 
                        <span id="dashboard-greeting"></span>
                    </p>
                </div>
                <div class="col-auto">
                    <a href="{{ route('logout') }}" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                       class="btn btn-outline-light btn-sm">
                        <i class="bi bi-box-arrow-right me-1"></i>Выйти
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Статистика пользователя -->
    <section class="py-5">
        <div class="container">
            <h2 class="fw-bold mb-4">Ваша статистика</h2>
            
            <!-- Vue приложение для статистики -->
            <div id="dashboard-stats">
                <div class="row g-4">
                    <!-- Карточка 1: Прогресс курса -->
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8);">
                                <i class="bi bi-mortarboard text-white"></i>
                            </div>
                            <div class="d-flex justify-content-between align-items-end">
                                <div>
                                    <div class="display-6 fw-bold">@{{ courseProgress }}%</div>
                                    <p class="text-muted mb-0">Прогресс курса</p>
                                </div>
                                <div class="position-relative">
                                    <svg class="progress-ring-dashboard" viewBox="0 0 100 100">
                                        <circle class="progress-ring-bg" cx="50" cy="50" r="40" stroke="#e2e8f0"/>
                                        <circle class="progress-ring-value" 
                                                cx="50" cy="50" r="40" 
                                                stroke="url(#gradient-progress)"
                                                :stroke-dasharray="251.2"
                                                :stroke-dashoffset="251.2 * (1 - courseProgress / 100)"/>
                                        <defs>
                                            <linearGradient id="gradient-progress" x1="0%" y1="0%" x2="100%" y2="0%">
                                                <stop offset="0%" stop-color="#3b82f6" />
                                                <stop offset="100%" stop-color="#1d4ed8" />
                                            </linearGradient>
                                        </defs>
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button @click="increaseProgress" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-plus-circle me-1"></i>Продолжить
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Карточка 2: Потраченное время -->
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon" style="background: linear-gradient(135deg, #10b981, #059669);">
                                <i class="bi bi-clock text-white"></i>
                            </div>
                            <div class="display-6 fw-bold mb-2">@{{ studyTime }}</div>
                            <p class="text-muted mb-3">Часов обучения</p>
                            <div class="course-progress">
                                <div class="course-progress-bar" :style="studyProgressStyle"></div>
                            </div>
                            <small class="text-muted">Цель: 40 часов</small>
                        </div>
                    </div>
                    
                    <!-- Карточка 3: Проекты -->
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);">
                                <i class="bi bi-laptop text-white"></i>
                            </div>
                            <div class="display-6 fw-bold mb-2">@{{ completedProjects }}</div>
                            <p class="text-muted mb-3">Завершённых проектов</p>
                            <div class="d-flex gap-2">
                                <span class="badge badge-pill bg-success">PHP</span>
                                <span class="badge badge-pill bg-info">Laravel</span>
                                <span class="badge badge-pill bg-warning">Vue</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Карточка 4: Уровень -->
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                                <i class="bi bi-trophy text-white"></i>
                            </div>
                            <div class="display-6 fw-bold mb-2">@{{ userLevel }}</div>
                            <p class="text-muted mb-3">Уровень разработчика</p>
                            <div class="course-progress">
                                <div class="course-progress-bar" :style="levelProgressStyle"></div>
                            </div>
                            <small class="text-muted">До след. уровня: @{{ xpToNextLevel }} XP</small>
                        </div>
                    </div>
                </div>
                
                <!-- Кнопка обновления -->
                <div class="text-center mt-4">
                    <button @click="updateAllStats" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-arrow-clockwise me-1"></i> Обновить статистику
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Активные курсы -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold mb-0">Мои курсы</h2>
                <a href="/start" class="btn btn-outline-primary">
                    <i class="bi bi-plus-circle me-1"></i>Найти новый курс
                </a>
            </div>
            
            <!-- Vue компонент курсов -->
            <div id="dashboard-courses">
                <div class="row g-4">
                    <!-- Курс 1 -->
                    <div class="col-md-4" v-for="course in courses" :key="course.id">
                        <div class="course-card">
                            <div class="p-4">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <span class="badge" :class="course.badgeClass">@{{ course.category }}</span>
                                        <h5 class="fw-bold mt-2 mb-1">@{{ course.title }}</h5>
                                    </div>
                                    <i :class="['fs-4', course.icon]"></i>
                                </div>
                                
                                <p class="text-muted small mb-3">@{{ course.description }}</p>
                                
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between small text-muted mb-1">
                                        <span>Прогресс</span>
                                        <span>@{{ course.progress }}%</span>
                                    </div>
                                    <div class="course-progress">
                                        <div class="course-progress-bar" :style="course.progressStyle"></div>
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="small text-muted">
                                        <i class="bi bi-clock me-1"></i>@{{ course.duration }}
                                    </div>
                                    <div>
                                        <button @click="continueCourse(course.id)" 
                                                class="btn btn-sm btn-primary">
                                            @{{ course.progress === 0 ? 'Начать' : 'Продолжить' }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Быстрые действия -->
    <section class="py-5">
        <div class="container">
            <h2 class="fw-bold mb-4">Быстрые действия</h2>
            
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="quick-action" @click="startNewProject">
                        <i class="bi bi-plus-circle display-5 mb-3"></i>
                        <h5 class="fw-bold">Новый проект</h5>
                        <p class="small text-muted mb-0">Создать свой первый сайт</p>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="quick-action" @click="openCodeEditor">
                        <i class="bi bi-code-slash display-5 mb-3"></i>
                        <h5 class="fw-bold">Песочница кода</h5>
                        <p class="small text-muted mb-0">Попрактиковаться в коде</p>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="quick-action" @click="viewAchievements">
                        <i class="bi bi-trophy display-5 mb-3"></i>
                        <h5 class="fw-bold">Достижения</h5>
                        <p class="small text-muted mb-0">@{{ achievementsCount }} из 20</p>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="quick-action" @click="openCommunity">
                        <i class="bi bi-people display-5 mb-3"></i>
                        <h5 class="fw-bold">Сообщество</h5>
                        <p class="small text-muted mb-0">@{{ communityMembers }} участников</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Последняя активность -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="fw-bold mb-4">Последняя активность</h2>
            
            <!-- Vue компонент активности -->
            <div id="dashboard-activity">
                <div class="card border-0">
                    <div class="card-body p-0">
                        <div v-if="activities.length === 0" class="text-center py-5">
                            <i class="bi bi-activity display-4 text-muted mb-3"></i>
                            <p class="text-muted">Активность не найдена</p>
                            <button @click="generateActivity" class="btn btn-primary">
                                <i class="bi bi-lightning me-1"></i>Создать активность
                            </button>
                        </div>
                        
                        <div v-else>
                            <div v-for="activity in activities" 
                                 :key="activity.id"
                                 class="d-flex align-items-center p-3 border-bottom">
                                <div class="flex-shrink-0">
                                    <div class="rounded-circle bg-light p-2" 
                                         :class="'text-' + activity.iconColor">
                                        <i :class="['bi', activity.icon]"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="mb-1 fw-medium">@{{ activity.title }}</p>
                                    <small class="text-muted">
                                        <i class="bi bi-clock me-1"></i>@{{ activity.time }}
                                    </small>
                                </div>
                                <div class="flex-shrink-0">
                                    <span class="badge" :class="activity.badgeClass">
                                        @{{ activity.status }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Статистика активности -->
                <div class="row mt-4">
                    <div class="col-md-3 text-center">
                        <div class="display-6 fw-bold text-primary">@{{ totalActivities }}</div>
                        <small class="text-muted">Всего активностей</small>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="display-6 fw-bold text-success">@{{ todayActivities }}</div>
                        <small class="text-muted">Сегодня</small>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="display-6 fw-bold text-warning">@{{ streakDays }}</div>
                        <small class="text-muted">Дней подряд</small>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="display-6 fw-bold text-info">@{{ averagePerDay }}</div>
                        <small class="text-muted">В среднем в день</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Мотивационное сообщение -->
    <section class="py-5">
        <div class="container">
            <div class="text-center">
                <div class="p-5 rounded-4 shadow-sm" 
                     style="background: linear-gradient(135deg, #fef3c7, #fde68a); border: 2px dashed #f59e0b;">
                    <i class="bi bi-stars display-1 text-warning mb-3"></i>
                    <h3 class="fw-bold mb-3">Ты на правильном пути! 🚀</h3>
                    <p class="lead mb-4">
                        Каждый день программирования приближает тебя к цели. 
                        Сегодня ты уже лучше, чем вчера!
                    </p>
                    <div class="d-flex justify-content-center gap-3">
                        <button @click="shareProgress" class="btn btn-warning">
                            <i class="bi bi-share me-2"></i>Поделиться прогрессом
                        </button>
                        <button @click="setGoal" class="btn btn-outline-warning">
                            <i class="bi bi-bullseye me-2"></i>Поставить новую цель
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    // Основное Vue приложение для статистики
    const { createApp: createStatsApp } = Vue;
    
    createStatsApp({
        data() {
            return {
                courseProgress: 35,
                studyTime: 18,
                completedProjects: 3,
                userLevel: 2,
                xp: 450,
                xpToNextLevel: 150
            }
        },
        computed: {
            studyProgressStyle() {
                const percent = (this.studyTime / 40) * 100;
                return `width: ${Math.min(percent, 100)}%; background: linear-gradient(90deg, #10b981, #059669);`;
            },
            levelProgressStyle() {
                const percent = (this.xp / 600) * 100;
                return `width: ${Math.min(percent, 100)}%; background: linear-gradient(90deg, #f59e0b, #d97706);`;
            }
        },
        methods: {
            increaseProgress() {
                if (this.courseProgress < 100) {
                    this.courseProgress += 5;
                    this.xp += 25;
                    this.updateXP();
                    
                    // Анимация
                    document.querySelector('.progress-ring-value').classList.add('pulse-animation');
                    setTimeout(() => {
                        document.querySelector('.progress-ring-value').classList.remove('pulse-animation');
                    }, 1000);
                }
            },
            updateXP() {
                // Уровень = каждые 300 XP
                this.userLevel = Math.floor(this.xp / 300) + 1;
                this.xpToNextLevel = (this.userLevel * 300) - this.xp;
            },
            updateAllStats() {
                // Симуляция обновления статистики
                this.courseProgress = Math.min(this.courseProgress + 2, 100);
                this.studyTime += 1;
                this.completedProjects += 1;
                this.xp += 50;
                this.updateXP();
                
                // Уведомление
                this.showNotification('Статистика обновлена! +50 XP');
            },
            showNotification(message) {
                // Создаём временное уведомление
                const notification = document.createElement('div');
                notification.className = 'position-fixed top-0 end-0 m-4 p-3 bg-success text-white rounded shadow';
                notification.style.zIndex = '9999';
                notification.innerHTML = `
                    <i class="bi bi-check-circle me-2"></i>
                    ${message}
                `;
                document.body.appendChild(notification);
                
                setTimeout(() => {
                    notification.remove();
                }, 3000);
            }
        },
        mounted() {
            this.updateXP();
        }
    }).mount('#dashboard-stats');
    
    // Vue приложение для курсов
    const { createApp: createCoursesApp } = Vue;
    
    createCoursesApp({
        data() {
            return {
                courses: [
                    {
                        id: 1,
                        title: 'Laravel с нуля',
                        category: 'Backend',
                        badgeClass: 'bg-primary',
                        icon: 'bi-server',
                        description: 'Основы PHP и фреймворка Laravel',
                        progress: 65,
                        duration: '12 часов',
                        progressStyle: 'width: 65%; background: linear-gradient(90deg, #3b82f6, #1d4ed8);'
                    },
                    {
                        id: 2,
                        title: 'Vue.js для начинающих',
                        category: 'Frontend',
                        badgeClass: 'bg-success',
                        icon: 'bi-code-square',
                        description: 'Интерактивные интерфейсы на Vue 3',
                        progress: 30,
                        duration: '8 часов',
                        progressStyle: 'width: 30%; background: linear-gradient(90deg, #10b981, #059669);'
                    },
                    {
                        id: 3,
                        title: 'Базы данных MySQL',
                        category: 'Базы данных',
                        badgeClass: 'bg-warning',
                        icon: 'bi-database',
                        description: 'Работа с SQL и миграциями',
                        progress: 0,
                        duration: '6 часов',
                        progressStyle: 'width: 0%; background: linear-gradient(90deg, #f59e0b, #d97706);'
                    }
                ]
            }
        },
        methods: {
            continueCourse(courseId) {
                const course = this.courses.find(c => c.id === courseId);
                if (course.progress === 0) {
                    course.progress = 10;
                } else {
                    course.progress = Math.min(course.progress + 20, 100);
                }
                
                // Обновляем прогресс бар
                course.progressStyle = `width: ${course.progress}%; background: linear-gradient(90deg, ${course.progress < 50 ? '#f59e0b' : course.progress < 80 ? '#3b82f6' : '#10b981'}, ${course.progress < 50 ? '#d97706' : course.progress < 80 ? '#1d4ed8' : '#059669'});`;
                
                this.showNotification(`Курс "${course.title}" продолжен!`);
            }
        }
    }).mount('#dashboard-courses');
    
    // Vue приложение для активности
    const { createApp: createActivityApp } = Vue;
    
    createActivityApp({
        data() {
            return {
                activities: [
                    {
                        id: 1,
                        icon: 'bi-check-circle',
                        iconColor: 'success',
                        title: 'Завершил урок "Основы PHP"',
                        time: '2 часа назад',
                        status: 'Завершено',
                        badgeClass: 'bg-success'
                    },
                    {
                        id: 2,
                        icon: 'bi-code-square',
                        iconColor: 'primary',
                        title: 'Написал первую миграцию',
                        time: 'Вчера',
                        status: 'Проверено',
                        badgeClass: 'bg-primary'
                    },
                    {
                        id: 3,
                        icon: 'bi-chat-dots',
                        iconColor: 'info',
                        title: 'Задал вопрос в сообществе',
                        time: '2 дня назад',
                        status: 'Ответ получен',
                        badgeClass: 'bg-info'
                    }
                ],
                totalActivities: 15,
                todayActivities: 3,
                streakDays: 7,
                averagePerDay: 2.1,
                achievementsCount: 8,
                communityMembers: 1245
            }
        },
        methods: {
            generateActivity() {
                const activitiesList = [
                    {
                        icon: 'bi-lightbulb',
                        iconColor: 'warning',
                        title: 'Создал новый проект',
                        time: 'Только что',
                        status: 'Новое',
                        badgeClass: 'bg-warning'
                    },
                    {
                        icon: 'bi-file-earmark-code',
                        iconColor: 'info',
                        title: 'Написал компонент Vue',
                        time: 'Только что',
                        status: 'В работе',
                        badgeClass: 'bg-info'
                    },
                    {
                        icon: 'bi-book',
                        iconColor: 'success',
                        title: 'Прочитал документацию',
                        time: 'Только что',
                        status: 'Завершено',
                        badgeClass: 'bg-success'
                    }
                ];
                
                const randomActivity = activitiesList[Math.floor(Math.random() * activitiesList.length)];
                this.activities.unshift({
                    id: Date.now(),
                    ...randomActivity
                });
                
                this.totalActivities++;
                this.todayActivities++;
                this.streakDays++;
                this.averagePerDay = (this.totalActivities / this.streakDays).toFixed(1);
                
                this.showNotification('Новая активность добавлена!');
            },
            startNewProject() {
                alert('Открываю создание нового проекта...');
                // Здесь будет редирект на создание проекта
            },
            openCodeEditor() {
                alert('Открываю песочницу кода...');
                // Здесь будет редирект на редактор кода
            },
            viewAchievements() {
                alert('Показываю достижения...');
                // Здесь будет редирект на страницу достижений
            },
            openCommunity() {
                alert('Открываю сообщество...');
                // Здесь будет редирект на чат/форум
            },
            shareProgress() {
                const shareText = `Я уже на ${this.$root.courseProgress}% курса веб-разработки! 🚀`;
                if (navigator.share) {
                    navigator.share({
                        title: 'Мой прогресс в DevStart',
                        text: shareText,
                        url: window.location.href
                    });
                } else {
                    alert(shareText + '\n\nСкопируйте это сообщение, чтобы поделиться.');
                }
            },
            setGoal() {
                const goal = prompt('Какую цель на сегодня поставим?', 'Изучить 2 урока Vue.js');
                if (goal) {
                    this.showNotification(`Цель установлена: "${goal}"`);
                }
            }
        }
    }).mount('#dashboard-activity');
    
    // Скрипт для приветствия по времени суток
    document.addEventListener('DOMContentLoaded', function() {
        const hour = new Date().getHours();
        let greeting;
        
        if (hour < 6) greeting = 'Доброй ночи! 🌙';
        else if (hour < 12) greeting = 'Доброе утро! ☀️';
        else if (hour < 18) greeting = 'Добрый день! 👋';
        else greeting = 'Добрый вечер! 🌇';
        
        document.getElementById('dashboard-greeting').textContent = greeting;
        
        // Обновляем время каждую минуту
        setInterval(() => {
            const now = new Date();
            const timeString = now.toLocaleTimeString('ru-RU', { 
                hour: '2-digit', 
                minute: '2-digit' 
            });
            
            const greetingEl = document.getElementById('dashboard-greeting');
            const hour = now.getHours();
            
            if (hour < 6) greeting = 'Доброй ночи! 🌙';
            else if (hour < 12) greeting = 'Доброе утро! ☀️';
            else if (hour < 18) greeting = 'Добрый день! 👋';
            else greeting = 'Добрый вечер! 🌇';
            
            greetingEl.textContent = `${greeting} (${timeString})`;
        }, 60000);
    });
</script>
@endpush