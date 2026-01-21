{{-- ============================================== --}}
{{-- ПРОСТАЯ ФОРМА ВХОДА                            --}}
{{-- ============================================== --}}

@extends('layouts.app')

@section('title', 'Вход - DevStart')

@push('styles')
<style>
    /* Используем те же стили что и для регистрации */
    .auth-page {
        min-height: 80vh;
        display: flex;
        align-items: center;
        padding: 100px 0;
    }
    
    .auth-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    
    .auth-header {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 40px;
        text-align: center;
    }
    
    .auth-body {
        padding: 40px;
    }
    
    .form-control-auth {
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        padding: 15px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }
    
    .form-control-auth:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
    }
    
    .btn-auth {
        background: linear-gradient(45deg, #10b981, #059669);
        border: none;
        color: white;
        padding: 15px;
        border-radius: 10px;
        font-size: 1.1rem;
        font-weight: 600;
        transition: all 0.3s ease;
        width: 100%;
    }
    
    .btn-auth:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);
    }
    
    .auth-link {
        color: #10b981;
        text-decoration: none;
        font-weight: 600;
    }
    
    .auth-link:hover {
        text-decoration: underline;
    }
    
    .forgot-password {
        font-size: 0.9rem;
        text-align: right;
        margin-top: -10px;
        margin-bottom: 20px;
    }
</style>
@endpush

@section('content')
    <section class="auth-page">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <!-- Карточка входа -->
                    <div class="auth-card">
                        <!-- Заголовок -->
                        <div class="auth-header">
                            <h2 class="mb-3">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Вход в аккаунт
                            </h2>
                            <p class="mb-0">Войдите, чтобы продолжить обучение</p>
                        </div>
                        
                        <!-- Тело формы -->
                        <div class="auth-body">
                            <!-- Форма Laravel -->
                            <form method="POST" action="{{ route('login') }}" id="loginForm">
                                @csrf
                                
                                <!-- Email -->
                                <div class="mb-4">
                                    <label for="email" class="form-label fw-bold">
                                        <i class="bi bi-envelope me-2"></i>Email
                                    </label>
                                    <input id="email" 
                                           type="email" 
                                           class="form-control form-control-auth @error('email') is-invalid @enderror" 
                                           name="email" 
                                           value="{{ old('email') }}" 
                                           required 
                                           autocomplete="email" 
                                           autofocus>
                                    
                                    @error('email')
                                        <div class="invalid-feedback d-block mt-2">
                                            <i class="bi bi-exclamation-triangle"></i> {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                
                                <!-- Пароль -->
                                <div class="mb-3">
                                    <label for="password" class="form-label fw-bold">
                                        <i class="bi bi-key me-2"></i>Пароль
                                    </label>
                                    <input id="password" 
                                           type="password" 
                                           class="form-control form-control-auth @error('password') is-invalid @enderror" 
                                           name="password" 
                                           required 
                                           autocomplete="current-password">
                                    
                                    <!-- Ссылка "Забыли пароль" -->
                                    <div class="forgot-password">
                                        <a href="{{ route('password.request') }}" class="auth-link">
                                            <i class="bi bi-question-circle me-1"></i>Забыли пароль?
                                        </a>
                                    </div>
                                    
                                    @error('password')
                                        <div class="invalid-feedback d-block mt-2">
                                            <i class="bi bi-exclamation-triangle"></i> {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                
                                <!-- Запомнить меня -->
                                <div class="form-check mb-4">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                    <label class="form-check-label" for="remember">
                                        Запомнить меня
                                    </label>
                                </div>
                                
                                <!-- Кнопка отправки -->
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-auth">
                                        <i class="bi bi-box-arrow-in-right me-2"></i>Войти
                                    </button>
                                    
                                    <a href="/register" class="btn btn-outline-success">
                                        <i class="bi bi-person-plus me-2"></i>Нет аккаунта? Зарегистрироваться
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Дополнительная информация -->
                    <div class="text-center mt-4">
                        <p class="text-muted">
                            <i class="bi bi-shield-lock me-1"></i> Безопасный вход
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    // Простое Vue приложение для формы входа
    const { createApp } = Vue;
    
    createApp({
        data() {
            return {
                email: '',
                password: '',
                remember: false
            }
        },
        
        computed: {
            // Простая проверка заполненности
            formIsValid() {
                return this.email && this.password;
            }
        },
        
        methods: {
            // Простая валидация email
            validateEmail() {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailRegex.test(this.email);
            }
        },
        
        mounted() {
            // Автофокус на email поле
            document.getElementById('email').focus();
            
            // Показываем ошибки если есть
            @if($errors->any())
                setTimeout(() => {
                    const firstError = document.querySelector('.is-invalid');
                    if (firstError) {
                        firstError.focus();
                    }
                }, 100);
            @endif
        }
    }).mount('#loginForm');
</script>
@endpush