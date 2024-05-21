<template>
  <q-layout>
    <div style="width: calc(100dvw-var(--scrollbar-width)); min-height:100vh;" class="q-pa-xl ">
      <h3 class="q-mb-xl">Checkout Submit Page</h3>
      <div class="flex justify-center items-center q-pa-md rounded-borders" style=" width: 100%; box-shadow: 7px 7px 26px #e6e6e6, 7px -7px 26px #ffffff;">
        <div class=" " style="width:100%;" >
          <div class="q-my-lg">
              <div class="text-h6 q-my-sm">Order number</div>
              {{checkoutData.order}}
          </div>

          <div class="q-my-lg">
            <div class="text-h6 q-my-sm">Transfer to</div>
            {{checkoutData.bank.number}} - {{ checkoutData.bank.name }}
          </div>

          <div class="row justify-end q-my-lg q-gutter-x-md">
            <q-btn @click="btnSubmit" >cofirm payment</q-btn>
          </div>
        </div>
      </div>
    </div>
  </q-layout>
</template>

<script setup>
import { api } from 'src/boot/axios'
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
// const fetch = ref({})
const checkoutData = ref({})

checkoutData.value = JSON.parse(sessionStorage.getItem('checkout'))

const btnSubmit = () => {
  api.put('setConfirmOrder', {
    order: checkoutData.value.order
  }).then((response) => {
    router.push({ name: 'ConfirmPaymentPage' })
  })
}

</script>
