<template>
  <q-layout>
    <div style="width: calc(100dvw-var(--scrollbar-width)); min-height:100vh;" class="q-pa-xl ">
      <h3 class="q-mb-xl">Confirm Payment</h3>
      <div class="flex justify-center items-center q-pa-md rounded-borders" style=" width: 100%; box-shadow: 7px 7px 26px #e6e6e6, 7px -7px 26px #ffffff;">
        <div class=" " style="width:100%;" >
          <div class="q-my-lg">
            <div class="text-h6 q-my-sm">Order Number</div>
            <q-input v-model="confirmData.order" outlined type="number" />
          </div>

          <div class="q-my-lg">
            <div class="text-h6 q-my-sm">Transfer Date</div>
            <q-input v-model="confirmData.date" outlined type="date" />
          </div>

          <div class="q-my-lg">
            <div class="text-h6 q-my-sm">Transfer to</div>
            <q-btn-dropdown  :label="confirmData.bank.name === ''? 'Select Bank' : confirmData.bank.number + ' - ' + confirmData.bank.name" class="q-mb-sm" >
              <q-list>
                <q-item v-for="item in fetch.bankList" :key="item" clickable v-close-popup @click="onItemClick(item)">
                  <q-item-section >
                  <q-item-label>{{ item.number }} - {{ item.name }}</q-item-label>
                  </q-item-section>
                </q-item>
              </q-list>
            </q-btn-dropdown>
          </div>

          <div class="q-my-lg">
            <div class="text-h6 q-my-sm">Bank Name</div>
            <q-input v-model="confirmData.bankName"  outlined type="text" />
          </div>

          <div class="q-my-lg">
            <div class="text-h6 q-my-sm">Bank Account Name</div>
            <q-input v-model="confirmData.accountName"  outlined type="text" />
          </div>

          <div class="q-my-lg">
            <div class="text-h6 q-my-sm">Bank Account Number</div>
            <q-input v-model="confirmData.accountNumber" outlined type="number" />
          </div>

          <div class="q-my-lg">
            <div class="text-h6 q-my-sm">Payment Reciept</div>
            <q-file v-model="files" label="Pick files" filled style="width: 100%;">
              <template v-slot:prepend>
                <q-icon name="upload" />
              </template>
            </q-file>
          </div>

          <div class="row justify-end q-my-lg q-gutter-x-md">
            <q-btn @click="btnSubmit" >Submit</q-btn>
          </div>
        </div>
      </div>
    </div>
  </q-layout>
</template>

<script setup>
import { ref } from 'vue'
import { api } from 'src/boot/axios.js'
import { useRouter } from 'vue-router'

const router = useRouter()
const files = ref(null)
const fetch = ref({})
const confirmData = ref({
  order: '',
  date: null,
  bankName: '',
  accountName: '',
  accountNumber: '',
  bank: {
    id: '',
    name: '',
    number: ''
  }
})

const getCheckout = () => {
  api.get('getCheckoutData')
    .then((response) => {
      fetch.value = response.data
    })
}
getCheckout()

const onItemClick = (data) => {
  confirmData.value.bank = data
}

const btnSubmit = () => {
  api.post('setConfirmPayment', {
    data: JSON.stringify(confirmData.value),
    files: files.value
  }).then((response) => {
    console.log(response)
    console.log(confirmData.value)
    router.push({ name: 'CartPage' })
  })
}

</script>
