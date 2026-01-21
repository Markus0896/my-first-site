<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'DevStart - Веб-разработка для начинающих')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
    <!-- Vue 3 (подключаем здесь для всех страниц) -->
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    
    <!-- Общие стили для всего сайта -->
    <style>
        :root {
            --primary: #6366f1;
            --secondary: #8b5cf6;
            --accent: #06b6d4;
        }
        
        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            padding-top: 76px; /* Отступ для фиксированной шапки */
        }
        
        /* Общие стили навигации */
        .main-navbar {
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .nav-brand {
            color: var(--primary) !important;
            font-weight: 700;
        }
        
        .nav-link.active {
            color: var(--primary) !important;
            font-weight: 600;
        }
        
        /* Общие стили кнопок */
        .btn-glow {
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            color: white;
            transition: all 0.3s ease;
        }
        
        .btn-glow:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(99, 102, 241, 0.3);
        }
        
        /* Общие стили футера */
        .main-footer {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            color: white;
            margin-top: auto;
        }
        
        .footer-link {
            color: #b0b0b0;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .footer-link:hover {
            color: white;
        }
        
        /* Vue демо (общее для всех страниц) */
        .vue-demo-card {
            border-left: 4px solid var(--primary);
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }
    </style>
    
    <!-- Дополнительные стили для конкретной страницы -->
    @stack('styles')
</head>
<body>
    <!-- ==================== -->
    <!-- НАВИГАЦИЯ (ОБЩАЯ ДЛЯ ВСЕХ СТРАНИЦ) -->
    <!-- ==================== -->
   <!-- ==================== -->
<!-- НАВИГАЦИЯ (ОБЩАЯ ДЛЯ ВСЕХ СТРАНИЦ) -->
<!-- ==================== -->
<nav class="navbar navbar-expand-lg navbar-light bg-white main-navbar fixed-top">
    <div class="container">
        <!-- Бренд/логотип -->
        <a class="navbar-brand nav-brand fw-bold" href="/">
            <i class="bi bi-rocket-takeoff-fill me-2"></i>
            DevStart
        </a>
        
        <!-- Кнопка мобильного меню -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <!-- Меню -->
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">
                        <i class="bi bi-house-door me-1"></i> Главная
                    </a>
                </li>
                
                <!-- Показываем Кабинет только авторизованным -->
                @auth
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="/dashboard">
                        <i class="bi bi-speedometer2 me-1"></i> Кабинет
                    </a>
                </li>
                @endauth
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('start') ? 'active' : '' }}" href="/start">
                        <i class="bi bi-play-circle me-1"></i> Курсы
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('about') ? 'active' : '' }}" href="/about">
                        <i class="bi bi-info-circle me-1"></i> О проекте
                    </a>
                </li>
                
                <!-- Разные кнопки для авторизованных/неавторизованных -->
                @auth
                <!-- Если пользователь вошёл, показываем выход -->
                <li class="nav-item">
                    <a class="nav-link btn btn-outline-danger ms-2" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right me-1"></i> Выйти
                    </a>
                </li>
                @else
                <!-- Если не вошёл, показываем регистрацию/вход -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('register') ? 'active' : '' }}" href="/register">
                        <i class="bi bi-person-plus me-1"></i> Регистрация
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('login') ? 'active' : '' }}" href="/login">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Вход
                    </a>
                </li>
                @endauth
            </ul>
            
            <!-- Vue компонент: Корзина/Счётчик (в навигации) -->
            @auth
            <div id="nav-cart" class="ms-3">
                <button @click="cartCount++" class="btn btn-outline-primary btn-sm position-relative">
                    <i class="bi bi-cart3"></i>
                    <span v-if="cartCount > 0" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        @{{ cartCount }}
                    </span>
                </button>
            </div>
            @endauth
        </div>
    </div>
</nav>

<!-- Форма для выхода (скрытая) -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>

    <!-- ==================== -->
    <!-- ОСНОВНОЙ КОНТЕНТ СТРАНИЦЫ -->
    <!-- ==================== -->
    <main class="min-vh-100">
        @yield('content')
    </main>

    <!-- ==================== -->
    <!-- VUE ДЕМО (ОБЩЕЕ ДЛЯ ВСЕХ СТРАНИЦ) -->
    <!-- ==================== -->
    <div class="container my-5">
        <div class="vue-demo-card p-4 rounded shadow-sm">
            <div id="vue-demo">
                <h4 class="text-center mb-4">
                    <i class="bi bi-magic me-2"></i> Интерактивность с Vue.js
                </h4>
                
                <div class="row justify-content-center">
                    <div class="col-md-8 text-center">
                        <div class="mb-4">
                            <button @click="increment" class="btn btn-lg btn-success me-3">
                                <i class="bi bi-plus-circle"></i> Добавить
                            </button>
                            <button @click="decrement" class="btn btn-lg btn-warning" :disabled="counter <= 0">
                                <i class="bi bi-dash-circle"></i> Убрать
                            </button>
                            <button @click="counter = 0" class="btn btn-lg btn-outline-danger ms-3">
                                <i class="bi bi-x-circle"></i> Сброс
                            </button>
                        </div>
                        
                        <div class="display-4 fw-bold mb-3" :class="counterClass">
                            @{{ counter }}
                        </div>
                        
                        <div class="alert" :class="messageClass" v-if="message">
                            <i class="bi" :class="messageIcon"></i> @{{ message }}
                        </div>
                        
                        <div class="progress mb-3" style="height: 20px;">
                            <div class="progress-bar" :style="progressStyle" role="progressbar"></div>
                        </div>
                        
                        <p class="text-muted small">
                            <i class="bi bi-lightbulb"></i> Это работает без перезагрузки страницы! Vue обновляет интерфейс мгновенно.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== -->
    <!-- ФУТЕР (ОБЩИЙ ДЛЯ ВСЕХ СТРАНИЦ) -->
    <!-- ==================== -->
    <footer class="main-footer py-5">
        <div class="container">
            <div class="row">
                <!-- Колонка 1: О проекте -->
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-rocket-takeoff-fill me-2"></i>DevStart
                    </h5>
                    <p class="text-white-50">Проект создан, чтобы сделать веб-разработку доступной для каждого. От идеи до первого сайта.</p>
                    <div class="d-flex gap-3">
                        <a href="#" class="footer-link"><i class="bi bi-telegram fs-5"></i></a>
                        <a href="#" class="footer-link"><i class="bi bi-youtube fs-5"></i></a>
                        <a href="#" class="footer-link"><i class="bi bi-github fs-5"></i></a>
                    </div>
                </div>
                
                <!-- Колонка 2: Навигация -->
                <div class="col-md-4 mb-4">
                    <h6 class="fw-bold mb-3">Быстрые ссылки</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="/" class="footer-link">Главная</a></li>
                        <li class="mb-2"><a href="/start" class="footer-link">Старт курса</a></li>
                        <li class="mb-2"><a href="/about" class="footer-link">О проекте</a></li>
                        <li class="mb-2"><a href="/register" class="footer-link">Регистрация</a></li>
                    </ul>
                </div>
                
                <!-- Колонка 3: Контакты -->
                <div class="col-md-4 mb-4">
                    <h6 class="fw-bold mb-3">Остались вопросы?</h6>
                    <p class="text-white-50"><i class="bi bi-envelope me-2"></i> hello@devstart.ru</p>
                    <div class="mt-4">
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Ваш email для обновлений">
                            <button class="btn btn-primary">
                                <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                        <small class="text-white-50 mt-2 d-block">Подпишитесь на новости проекта</small>
                    </div>
                </div>
            </div>
            
            <hr class="my-4 opacity-25">
            
            <div class="text-center text-white-50">
                <small>© 2024 DevStart. Создано с ❤️ для начинающих разработчиков.</small>
            </div>
        </div>
    </footer>

    <!-- ==================== -->
    <!-- ОБЩИЕ СКРИПТЫ -->
    <!-- ==================== -->
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Общий Vue скрипт для всего сайта -->
    <script>
        // Vue приложение для навигации (корзина)
        const { createApp: createNavApp } = Vue;
        createNavApp({
            data() {
                return {
                    cartCount: 0
                }
            }
        }).mount('#nav-cart');
        
        // Vue приложение для демо-блока
        const { createApp: createDemoApp } = Vue;
        createDemoApp({
            data() {
                return {
                    counter: 0,
                    maxValue: 20
                }
            },
            computed: {
                message() {
                    if (this.counter === 0) return 'Начни кликать!';
                    if (this.counter < 5) return 'Хороший старт!';
                    if (this.counter < 10) return 'Отлично! Ты на пути к успеху!';
                    if (this.counter < 15) return 'Великолепно! Ты - программист!';
                    return 'Супер! Ты мастер Vue! 🎉';
                },
                messageClass() {
                    if (this.counter === 0) return 'alert-info';
                    if (this.counter < 5) return 'alert-warning';
                    if (this.counter < 10) return 'alert-primary';
                    return 'alert-success';
                },
                messageIcon() {
                    if (this.counter === 0) return 'bi-emoji-smile';
                    if (this.counter < 5) return 'bi-emoji-wink';
                    if (this.counter < 10) return 'bi-emoji-laughing';
                    return 'bi-emoji-heart-eyes';
                },
                counterClass() {
                    if (this.counter > 15) return 'text-success';
                    if (this.counter > 10) return 'text-primary';
                    if (this.counter > 5) return 'text-warning';
                    return 'text-secondary';
                },
                progressStyle() {
                    const percent = (this.counter / this.maxValue) * 100;
                    return `width: ${Math.min(percent, 100)}%; background: linear-gradient(90deg, #6366f1, #8b5cf6);`;
                }
            },
            methods: {
                increment() {
                    if (this.counter < this.maxValue) {
                        this.counter++;
                    }
                },
                decrement() {
                    if (this.counter > 0) {
                        this.counter--;
                    }
                }
            },
            mounted() {
                console.log('Vue демо загружено!');
            }
        }).mount('#vue-demo');
        
        // Общая логика для всех страниц
        document.addEventListener('DOMContentLoaded', function() {
            // Активируем текущую ссылку в навигации
            const currentPath = window.location.pathname;
            document.querySelectorAll('.nav-link').forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                }
            });
            
            // Плавная прокрутка для якорей
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({ behavior: 'smooth' });
                    }
                });
            });
        });
    </script>
    
    <!-- Дополнительные скрипты для конкретной страницы -->
    @stack('scripts')
</body>
</html>