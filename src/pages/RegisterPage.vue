<template>
  <q-layout>
    <div style="width: calc(100dvw-var(--scrollbar-width)); min-height:100vh;" class="q-pa-xl column items-center">
        <h1 class="q-mb-xl text-center">Register</h1>

        <q-form class=" q-gutter-y-md column items-center "  style="width: 50%;">
          <div style="width: 100%;">
            <q-input v-model="email" outlined rounded placeholder="Email"  class=""  style="width: 100%;"></q-input>
          <p v-if="emailErr !== ''" class="q-ml-md q-mt-sm" style="color: red;">{{ emailErr }}</p>
          </div>
         <div style="width: 100%;">
          <q-input v-model="password" :type="isPwd ? 'password' : 'text'" outlined rounded placeholder="Password" class="" style="width: 100%;" >
            <template v-slot:append>
              <q-icon
              :name="isPwd ? 'visibility_off' : 'visibility'"
              class="cursor-pointer"
              @click="isPwd = !isPwd"
              />
            </template>
          </q-input>
          <p  v-if="passwordErr !== ''" class="q-ml-md q-mt-sm" style="color: red;">{{ passwordErr }}</p>
         </div>

          <div style="width: 100%;">
            <q-input v-model="cPassword" :type="isCPwd ? 'password' : 'text'" outlined rounded placeholder="Confirmation Password" class="" style="width: 100%;" >
            <template v-slot:append>
              <q-icon
              :name="isPwd ? 'visibility_off' : 'visibility'"
              class="cursor-pointer"
              @click="isCPwd = !isCPwd"
              />
            </template>
          </q-input>
          <p v-if="cPasswordErr !== ''" class="q-ml-md q-mt-sm" style="color: red;">{{ cPasswordErr }}</p>
          </div>

          <div style="width: 100%;" >
            <q-input v-model="name" type="text" outlined rounded placeholder="Name"  class=""  style="width: 100%;"></q-input>
          <p v-if="nameErr !== ''" class="q-ml-md q-mt-sm" style="color: red;">{{ nameErr }}</p>
          </div>

          <div style="width: 100%;">
            <q-input v-model="phone" type="number" outlined rounded placeholder="Phone"  class=""  style="width: 100%;"></q-input>
          <p v-if="phoneErr !== ''" class="q-ml-md q-mt-sm" style="color: red;">{{ phoneErr }}</p>
          </div>

          <div class=" q-mt-lg column q-gutter-y-md" style="width: 30%;" >
            <q-btn rounded  label="Register" color="primary" type="submit"  @click="btnRegister"/>
            <q-btn rounded  label="Login Page" color="primary" type="submit"  @click.prevent="router.push({name: 'LoginPage'})"/>
          </div>
        </q-form>

    </div>
  </q-layout>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { api } from 'src/boot/axios.js'

const router = useRouter()

const isPwd = ref(true)
const isCPwd = ref(true)

const email = ref('')
const emailErr = ref('')
const name = ref('')
const nameErr = ref('')
const phone = ref('')
const phoneErr = ref('')
const password = ref('')
const passwordErr = ref('')
const cPassword = ref('')
const cPasswordErr = ref('')

// const checkToken = () => {
//   api.get('checkToken').then(() => {
//     router.push({ name: 'HomePage' })
//   })
// }

// checkToken()

const btnRegister = () => {
  api.post('registerMember', {
    email: email.value,
    password: password.value,
    cpassword: cPassword.value,
    name: name.value,
    phone: phone.value
  }).then((response) => {
    router.push({ name: 'LoginPage' })
  }).catch((err) => {
    emailErr.value = err.response.data.messages.error.email
    passwordErr.value = err.response.data.messages.error.password
    cPasswordErr.value = err.response.data.messages.error.cpassword
    nameErr.value = err.response.data.messages.error.name
    phoneErr.value = err.response.data.messages.error.phone
  })
}

</script>
