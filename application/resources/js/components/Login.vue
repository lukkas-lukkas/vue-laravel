<template>
  <div class="container">
    <div class="row justify-content-center mt-5">
      <div class="col-md-8 mt-5">
        <div class="card">
          <div class="card-header">Login</div>
          <div class="card-body">
            <div>
              <input type="hidden" name="_token" :value="csrf_token">
              <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">E-mail</label>

                <div class="col-md-6">
                  <input id="email" type="email" class="form-control" name="email" v-model="email" required
                    autocomplete="email" autofocus>
                </div>
              </div>

              <div class="form-group row mt-3 mb-2">
                <label for="password" class="col-md-4 col-form-label text-md-right">Senha</label>

                <div class="col-md-6">
                  <input id="password" type="password" class="form-control" name="password" v-model="password" required
                    autocomplete="current-password">
                </div>
              </div>

              <div class="form-group row">
                <div class="col-md-6 offset-md-4">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">

                    <label class="form-check-label" for="remember">
                      Mantenha-me conectado
                    </label>
                  </div>
                </div>
              </div>

              <div class="form-group row mb-0 mt-4">
                <div class="col-md-8 offset-md-4">
                  <button type="submit" class="btn btn-primary" @click="login">
                    Login
                  </button>

                  <a class="btn btn-link" href="#">
                    Esqueci a senha
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['csrf_token'],
  data() {
    return {
      email: '',
      password: ''
    }
  },
  methods: {
    login() {
      if (this.email.length == 0) {
        alert('Email required');
        return;
      }

      if (this.password.length == 0) {
        alert('Password required');
        return;
      }

      const url = 'http://localhost:9001/api/get-token';
      const config = {
        method: 'post',
        body: new URLSearchParams({
          'email': this.email,
          'password': this.password
        })
      };

      fetch(url, config)
        .then(response => response.json())
        .then(data => {
          if (data.token) {
            document.cookie = 'vue_laravel_token=' + data.token;
            window.location.href = 'http://localhost:9001';
          }
        })
        .catch(error => {
          console.log('Fetch error', error);
          alert('We had a little problem, please try later');
        })
    }
  }
}
</script>