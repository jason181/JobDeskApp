<template>
  <v-content>
    <v-container
      fill-height
      fluid>
      <v-layout
        align-center
        justify-center>
        <v-flex
          xs12
          sm8
          md4>
          <v-card
            class="elevation-12">
            <v-toolbar
              color="general">
              <v-toolbar-title>Login Panel</v-toolbar-title>
              <v-spacer/>
            </v-toolbar>
            <v-card-text>
              <v-form >
                <v-text-field
                  ref="username"
                  v-model="username"
                  :rules="[() => !!username || 'This field is required']"
                  prepend-icon="mdi-account"
                  label="Login"
                  placeholder="Username"
                  required
                />
                <v-text-field
                  ref="password"
                  v-model="password"
                  :rules="[() => !!password || 'This field is required']"
                  :append-icon="showPassword ? 'mdi-eye-off' : 'mdi-eye'"
                  :type="showPassword ? 'text' : 'password'"
                  prepend-icon="mdi-lock"
                  label="Password"
                  placeholder="*********"
                  counter
                  required
                  @keydown.enter="login"
                  @click:append="showPassword = !showPassword"
                />
              </v-form>
            </v-card-text>
            <v-divider class="mt-5"/>
            <v-card-actions>
              <span style="font-size:8pt;">v 1.0.0</span>
              <v-spacer/>
              <v-btn
                align-center
                justify-center
                color="general"
                @click="login">Login
              </v-btn>
            </v-card-actions>
            <v-snackbar
            v-model="showResult"
            :timeout="2000"
            top>
            {{ result }}
          </v-snackbar>
          <!-- Alert -->
          <v-snackbar right bottom :color="alert.type"  value="true" v-if="alert.type">
            <v-icon>{{alert.icon}}</v-icon>{{alert.message}}
          </v-snackbar>
          </v-card>
        </v-flex>
      </v-layout>
      
    </v-container>
  </v-content>
</template>

<script>
import auth from '../service/Auth'
import Controller from '../httpController'
export default {
  data: function () {
    return {
      username: '',
      password: '',
      errorMessages: 'Incorrect login info',
      snackbar: false,
      color: 'general',
      showPassword: false,
      showResult: false,
      result: '',
      alert:{
        type: null,
        message: null,
        icon: null,
      },
    }
  },

  // Sends action to Vuex that will log you in and redirect to the dash otherwise, error
  methods: {
    login(){
      try {
          this.authenticate()
          this.addLogSesi()
          // console.log("test")
          this.$router.push({ name: 'Dashboard' })
        } catch (err) {
           this.showAlert('error','Gagal Login')
        }
    },
    async authenticate() {
        try {
          const data= {
            username : this.username,
            password : this.password,
          }
          await auth.authenticate(data)
          this.$router.push({ name: 'Dashboard' })
        } catch (err) {
           this.showAlert('error','Gagal Login, Username atau Password salah!')
        }
    },
    async addLogSesi(){
      try {
          let payload={
            Username    : this.username,
            Keterangan  : 'Login'
          }
          await Controller.addsessionlog(payload)
          this.$router.push({ name: 'Dashboard' })
        } catch (err) {
           this.showAlert('error','Gagal Login, Silahkan Coba Lagi')
        }
    },
    showAlert (type,alert_message) {

        if(type == 'success'){
          this.alert.icon = 'fas fa-check-circle'
        }
        else if(type == 'error'){
          this.alert.icon = 'fas fa-exclamation-circle'
        }

        this.alert.type = type
        this.alert.message = alert_message
        
        let timer = this.showAlert.timer
        if (timer) {
          clearTimeout(timer)
        }
        this.showAlert.timer = setTimeout(() => {
            this.alert.type = null
            this.alert.icon = null
            this.alert.message = null
        }, 3000)
        
      }
  },
  metaInfo () {
    return {
      title: 'Super Secret | Login'
    }
  }
}
</script>
