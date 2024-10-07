<template>
    <div class="login">
        <section class="login_container">
            <section class="wrapper">
                <header>
                    <div class="logo">
                        <img src="/images/logo.png">
                    </div>
                    <!-- <p>User Login</p> -->
                </header>
                <section class="main-content">
                    <div class="d_flex_center mb_20">
                        <div class="form_radio">
                            <input type="radio" id="Checkme3" name="radio" value="student" v-model="loginForm.type">
                            <label for="Checkme3">{{ trans('common.index.student') }}</label>
                        </div>
                        <div class="form_radio">
                            <input type="radio" id="Checkme2" name="radio" value="professor" v-model="loginForm.type">
                            <label for="Checkme2">{{ trans('common.index.professor') }}</label>
                        </div>
                        <div class="form_radio">
                            <input type="radio" id="Checkme1" name="radio" value="admin" v-model="loginForm.type">
                            <label for="Checkme1">{{ trans('common.index.admin') }}</label>
                        </div>
                    </div>
                    <form action="">
                        <input type="email" :placeholder="trans('common.index.email')" v-model="loginForm.email">
                        <input type="password" :placeholder="trans('common.index.password')" v-model="loginForm.password">
                        <button class="mt_20" @click.prevent="login">{{ trans('common.index.login') }}</button>
                    </form>
                </section>
            </section>
        </section>
    </div>
</template>

<script>
export default {
    data() {
        return {
            loginForm: {
                type: 'student',
                email: null,
                password: null,
                device: 'web'
            }
        }
    },
    methods: {
        async login() {
            this.errors = null;
            this.loading = true;

            await axios.get('/sanctum/csrf-cookie');

            await this.$store.dispatch('login', this.loginForm)
                .then((res) => window.location.href = "/" + res.type)
                .catch((err) => {
                    this.$swal({
                        toast: true,
                        position: 'top-right',
                        showConfirmButton: false,
                        timer: 1500,
                        timerProgressBar: true,
                        title: err.errors.email,
                        icon: 'error',
                    });
                })
                .finally(() => this.loading = false);
        },
    }
}
</script>
