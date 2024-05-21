<template>
  <q-layout>
    <div style="width: calc(100dvw-var(--scrollbar-width)); height:100vh;" class="q-pa-xl column items-center">
        <h1 class="q-mb-xl text-center">Login</h1>

        <q-form class=" q-gutter-y-md column items-center "  style="width: 50%;">
          <q-input v-model="email" outlined rounded placeholder="Email"  class=""  style="width: 100%;"></q-input>
          <q-input v-model="password" :type="isPwd ? 'password' : 'text'" outlined rounded placeholder="Password" class="" style="width: 100%;" >
            <template v-slot:append>
              <q-icon
              :name="isPwd ? 'visibility_off' : 'visibility'"
              class="cursor-pointer"
              @click="isPwd = !isPwd"
              />
            </template>
          </q-input>

          <div class=" q-mt-lg column q-gutter-y-md" style="width: 30%;" >
            <q-btn rounded  label="Log In" color="primary" type="submit"  @click="btnLogin"/>
            <q-btn rounded  label="Register Page" color="primary" type="submit"  @click.prevent="router.push({name: 'RegisterPage'})"/>
          </div>
        </q-form>

        <!-- Dialog -->

        <q-dialog v-model="alertDialog" class="q-px-sm">
          <q-card style="width:60%;">
            <q-card-section class="text-center">
              <h5 style="font-weight: bold;">Wrong Email or Password</h5>
            </q-card-section>

            <q-card-actions align="right">
              <q-btn flat label="OK" @click="alertDialog = false" color="light-blue-10"/>
            </q-card-actions>
          </q-card>
        </q-dialog>

    </div>
  </q-layout>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { api } from 'src/boot/axios.js'
// import { route } from 'quasar/wrappers'

const router = useRouter()

const alertDialog = ref(false)
const isPwd = ref(true)

const email = ref('')
const password = ref('')

// const checkToken = () => {
//   api.get('checkToken').then(() => {
//     router.push({ name: 'HomePage' })
//   })
// }

// checkToken()

const btnLogin = () => {
  api.post('loginMember', {
    email: email.value,
    password: password.value
  }).then((response) => {
    console.log(response)
    localStorage.setItem('token', response.data)
    router.push({ name: 'ProductPage' })
  }).catch((err) => {
    console.log(err)
    alertDialog.value = true
  })
}

</script>
