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
                    autocomplete="current-password" v-on:keyup.enter="login">
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
import { COOKIE_TOKEN, URL_BASE } from "../constants.js"
import clientHttp from "../clientHttp";

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

      clientHttp.post('/api/get-token', {
        'email': this.email,
        'password': this.password
      }).then(response => {

        document.cookie = `${COOKIE_TOKEN}=${response.data.token}`;
        window.location.href = URL_BASE + '/clients';
        
      }).catch(error => {
        //https://axios-http.com/docs/handling_errors
        if (error.response) {

          switch (error.response.status) {            
            case 422:
              console.error('Payload validation error to get token');
              alert('We had a little problem, please try later');
              break;

            case 401:
              alert('User or password invalid.')
              break;

            default:
              console.error('Req to get token, result in status code '.error.response.status);
              alert('We had a little problem, please try later');
          }

        } else {
          alert('We had a little problem, please try later');
        }
      });
    }
  }
}
</script>