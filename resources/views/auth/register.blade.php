{{-- ============================================== --}}
{{-- ПРОСТАЯ ФОРМА РЕГИСТРАЦИИ                     --}}
{{-- ============================================== --}}

@extends('layouts.app')

@section('title', 'Регистрация - DevStart')

@push('styles')
<style>
    /* Стили для страницы регистрации */
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
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
    }
    
    .btn-auth {
        background: linear-gradient(45deg, #6366f1, #8b5cf6);
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
        box-shadow: 0 10px 20px rgba(99, 102, 241, 0.3);
    }
    
    .auth-link {
        color: #6366f1;
        text-decoration: none;
        font-weight: 600;
    }
    
    .auth-link:hover {
        text-decoration: underline;
    }
    
    /* Простая валидация Vue */
    .validation-message {
        font-size: 0.85rem;
        margin-top: 5px;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    .validation-valid {
        color: #10b981;
    }
    
    .validation-invalid {
        color: #ef4444;
    }
</style>
@endpush

@section('content')
    <section class="auth-page">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <!-- Карточка регистрации -->
                    <div class="auth-card">
                        <!-- Заголовок -->
                        <div class="auth-header">
                            <h2 class="mb-3">
                                <i class="bi bi-person-plus-fill me-2"></i>Регистрация
                            </h2>
                            <p class="mb-0">Создайте аккаунт, чтобы начать обучение</p>
                        </div>
                        
                        <!-- Тело формы -->
                        <div class="auth-body">
                            <!-- Форма Laravel -->
                            <form method="POST" action="{{ route('register') }}" id="registerForm">
                                @csrf
                                
                                <!-- Имя -->
                                <div class="mb-4">
                                    <label for="name" class="form-label fw-bold">
                                        <i class="bi bi-person me-2"></i>Имя
                                    </label>
                                    <input id="name" 
                                           type="text" 
                                           class="form-control form-control-auth @error('name') is-invalid @enderror" 
                                           name="name" 
                                           value="{{ old('name') }}" 
                                           required 
                                           autocomplete="name" 
                                           autofocus
                                           v-model="form.name">
                                    
                                    <!-- Vue валидация -->
                                    <div v-if="nameMessage" class="validation-message" :class="nameValid ? 'validation-valid' : 'validation-invalid'">
                                        <i :class="nameValid ? 'bi bi-check-circle' : 'bi bi-exclamation-circle'"></i>
                                        @{{ nameMessage }}
                                    </div>
                                    
                                    <!-- Laravel ошибки -->
                                    @error('name')
                                        <div class="invalid-feedback d-block mt-2">
                                            <i class="bi bi-exclamation-triangle"></i> {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                
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
                                           v-model="form.email">
                                    
                                    <!-- Vue валидация -->
                                    <div v-if="emailMessage" class="validation-message" :class="emailValid ? 'validation-valid' : 'validation-invalid'">
                                        <i :class="emailValid ? 'bi bi-check-circle' : 'bi bi-exclamation-circle'"></i>
                                        @{{ emailMessage }}
                                    </div>
                                    
                                    @error('email')
                                        <div class="invalid-feedback d-block mt-2">
                                            <i class="bi bi-exclamation-triangle"></i> {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                
                                <!-- Пароль -->
                                <div class="mb-4">
                                    <label for="password" class="form-label fw-bold">
                                        <i class="bi bi-key me-2"></i>Пароль
                                    </label>
                                    <input id="password" 
                                           type="password" 
                                           class="form-control form-control-auth @error('password') is-invalid @enderror" 
                                           name="password" 
                                           required 
                                           autocomplete="new-password"
                                           v-model="form.password">
                                    
                                    <!-- Простая индикация пароля -->
                                    <div v-if="form.password" class="mt-2">
                                        <small :class="passwordStrengthClass">
                                            <i :class="passwordStrengthIcon"></i> @{{ passwordStrengthText }}
                                        </small>
                                        <div class="progress mt-1" style="height: 5px;">
                                            <div class="progress-bar" :style="passwordStrengthStyle"></div>
                                        </div>
                                    </div>
                                    
                                    @error('password')
                                        <div class="invalid-feedback d-block mt-2">
                                            <i class="bi bi-exclamation-triangle"></i> {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                
                                <!-- Подтверждение пароля -->
                                <div class="mb-4">
                                    <label for="password_confirmation" class="form-label fw-bold">
                                        <i class="bi bi-key-fill me-2"></i>Подтвердите пароль
                                    </label>
                                    <input id="password_confirmation" 
                                           type="password" 
                                           class="form-control form-control-auth" 
                                           name="password_confirmation" 
                                           required 
                                           autocomplete="new-password"
                                           v-model="form.password_confirmation">
                                    
                                    <!-- Vue валидация -->
                                    <div v-if="passwordConfirmationMessage" class="validation-message" :class="passwordConfirmationValid ? 'validation-valid' : 'validation-invalid'">
                                        <i :class="passwordConfirmationValid ? 'bi bi-check-circle' : 'bi bi-exclamation-circle'"></i>
                                        @{{ passwordConfirmationMessage }}
                                    </div>
                                </div>
                                
                                <!-- Соглашение -->
                                <div class="form-check mb-4">
                                    <input class="form-check-input" type="checkbox" id="terms" required>
                                    <label class="form-check-label" for="terms">
                                        Я соглашаюсь с 
                                        <a href="#" class="auth-link">условиями</a> и 
                                        <a href="#" class="auth-link">политикой конфиденциальности</a>
                                    </label>
                                </div>
                                
                                <!-- Кнопка отправки -->
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-auth" :disabled="!formIsValid">
                                        <span v-if="isSubmitting">
                                            <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                            Регистрируем...
                                        </span>
                                        <span v-else>
                                            <i class="bi bi-person-plus me-2"></i>Зарегистрироваться
                                        </span>
                                    </button>
                                    
                                    <a href="/login" class="btn btn-outline-primary">
                                        <i class="bi bi-box-arrow-in-right me-2"></i>Уже есть аккаунт? Войти
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Дополнительная информация -->
                    <div class="text-center mt-4">
                        <p class="text-muted">
                            <i class="bi bi-shield-check me-1"></i> Ваши данные в безопасности
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    // Простое Vue приложение для формы регистрации
    const { createApp } = Vue;
    
    createApp({
        data() {
            return {
                form: {
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: ''
                },
                nameValid: false,
                nameMessage: '',
                emailValid: false,
                emailMessage: '',
                passwordConfirmationValid: false,
                passwordConfirmationMessage: '',
                isSubmitting: false
            }
        },
        
        computed: {
            // Проверка формы
            formIsValid() {
                return this.nameValid && 
                       this.emailValid && 
                       this.form.password.length >= 8 &&
                       this.passwordConfirmationValid;
            },
            
            // Сложность пароля
            passwordStrengthText() {
                const length = this.form.password.length;
                if (length === 0) return 'Введите пароль';
                if (length < 4) return 'Очень слабый';
                if (length < 8) return 'Слабый';
                if (length < 12) return 'Средний';
                if (length < 16) return 'Хороший';
                return 'Отличный!';
            },
            
            passwordStrengthClass() {
                const length = this.form.password.length;
                if (length === 0) return 'text-muted';
                if (length < 4) return 'text-danger';
                if (length < 8) return 'text-warning';
                if (length < 12) return 'text-info';
                if (length < 16) return 'text-primary';
                return 'text-success';
            },
            
            passwordStrengthIcon() {
                const length = this.form.password.length;
                if (length === 0) return 'bi bi-info-circle';
                if (length < 4) return 'bi bi-exclamation-triangle';
                if (length < 8) return 'bi bi-exclamation-circle';
                if (length < 12) return 'bi bi-check-circle';
                return 'bi bi-shield-check';
            },
            
            passwordStrengthStyle() {
                const length = this.form.password.length;
                const percent = Math.min((length / 16) * 100, 100);
                
                if (length < 4) return 'width: ' + percent + '%; background: #ef4444;';
                if (length < 8) return 'width: ' + percent + '%; background: #f59e0b;';
                if (length < 12) return 'width: ' + percent + '%; background: #3b82f6;';
                return 'width: ' + percent + '%; background: #10b981;';
            }
        },
        
        methods: {
            // Валидация имени
            validateName() {
                const name = this.form.name.trim();
                
                if (!name) {
                    this.nameValid = false;
                    this.nameMessage = 'Введите ваше имя';
                    return;
                }
                
                if (name.length < 2) {
                    this.nameValid = false;
                    this.nameMessage = 'Имя слишком короткое';
                    return;
                }
                
                this.nameValid = true;
                this.nameMessage = 'Отлично!';
            },
            
            // Валидация email
            validateEmail() {
                const email = this.form.email.trim();
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                
                if (!email) {
                    this.emailValid = false;
                    this.emailMessage = 'Введите email';
                    return;
                }
                
                if (!emailRegex.test(email)) {
                    this.emailValid = false;
                    this.emailMessage = 'Некорректный email';
                    return;
                }
                
                this.emailValid = true;
                this.emailMessage = 'Email корректен';
            },
            
            // Валидация подтверждения пароля
            validatePasswordConfirmation() {
                if (!this.form.password_confirmation) {
                    this.passwordConfirmationValid = false;
                    this.passwordConfirmationMessage = 'Подтвердите пароль';
                    return;
                }
                
                if (this.form.password !== this.form.password_confirmation) {
                    this.passwordConfirmationValid = false;
                    this.passwordConfirmationMessage = 'Пароли не совпадают';
                    return;
                }
                
                this.passwordConfirmationValid = true;
                this.passwordConfirmationMessage = 'Пароли совпадают';
            },
            
            // Отправка формы
            submitForm() {
                if (this.formIsValid) {
                    this.isSubmitting = true;
                    
                    // Форма отправится через Laravel
                    setTimeout(() => {
                        document.getElementById('registerForm').submit();
                    }, 1000);
                }
            }
        },
        
        watch: {
            // Автоматическая валидация при изменении полей
            'form.name': 'validateName',
            'form.email': 'validateEmail',
            'form.password_confirmation': 'validatePasswordConfirmation'
        },
        
        mounted() {
            // Инициализация
            this.validateName();
            this.validateEmail();
            this.validatePasswordConfirmation();
            
            // Обработка отправки
            const form = document.getElementById('registerForm');
            form.addEventListener('submit', (e) => {
                if (!this.formIsValid) {
                    e.preventDefault();
                    alert('Пожалуйста, заполните все поля корректно');
                }
            });
        }
    }).mount('#registerForm');
</script>
@endpush