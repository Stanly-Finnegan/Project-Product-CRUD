<template>
  <q-layout>
    <div style="width: 100vw; height:100vh;" class="q-pa-xl column items-center">
        <h1 class="q-mb-xl text-center">Home Page</h1>

        <div class=" column q-gutter-y-md q-mt-xl" style="width: 50%;">
          <q-btn size='xl' rounded  label="Product Page" color="primary" type="submit" @click="toProduct"/>
            <q-btn size='xl' rounded  label="Order Page" color="primary" type="submit" @click="toOrder"/>
        </div>

    </div>
  </q-layout>
</template>

<script setup>
// import { ref } from 'vue'
import { api } from 'src/boot/axios'
import { useRouter } from 'vue-router'

const router = useRouter()

const toProduct = () => {
  router.push({ name: 'ProductPage' })
}

const checkToken = () => {
  api.get('checkToken').then(() => {
  }).catch(() => {
    router.push({ name: 'LoginPage' })
  })
}

checkToken()

const toOrder = () => {
  router.push({ name: 'OrderPage' })
}

</script>
