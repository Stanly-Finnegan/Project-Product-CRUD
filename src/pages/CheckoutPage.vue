<template>
  <q-layout>
    <div style="width: calc(100dvw-var(--scrollbar-width)); min-height:100vh;" class="q-pa-xl ">
      <h3 class="q-mb-xl">Checkout Page</h3>
      <div class="flex justify-center items-center q-pa-md rounded-borders" style=" width: 100%; box-shadow: 7px 7px 26px #e6e6e6, 7px -7px 26px #ffffff;">
        <div class=" " style="width:100%;" >
          <div class="row q-my-lg">
            <div class="col-6">
              <div class="text-h6 q-my-sm">Email</div>
              {{fetch.email}}
            </div>
            <div class="col-6 row justify-end">
              <div>
                <div class="text-h6 q-my-sm">Total Payment</div>
                <div class="text-h5">Rp. {{fetch.totalPayment}}</div>
              </div>
            </div>
          </div>

          <div class="q-my-lg">
            <div class="text-h6 q-my-sm">Name</div>
            {{fetch.name}}
          </div>

          <div class="q-my-lg">
            <div class="text-h6 q-my-sm">Address</div>
            <q-input v-model="checkoutData.address" outlined type="textarea" />
          </div>

          <div class="q-my-lg">
            <div class="text-h6 q-my-sm">Transfer to</div>
            <q-btn-dropdown  :label="checkoutData.bank.name === ''? 'Select Bank' : checkoutData.bank.number + ' - ' + checkoutData.bank.name" class="q-mb-sm" >
              <q-list>
                <q-item v-for="item in fetch.bankList" :key="item" clickable v-close-popup @click="onItemClick(item)">
                  <q-item-section >
                  <q-item-label>{{ item.number }} - {{ item.name }}</q-item-label>
                  </q-item-section>
                </q-item>
              </q-list>
            </q-btn-dropdown>
          </div>

          <div class="row justify-end q-my-lg q-gutter-x-md">
            <q-btn color="grey" @click="btnBack">Back to Cart</q-btn>
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
const fetch = ref({})
const checkoutData = ref({
  address: '',
  order: '',
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
  checkoutData.value.bank = data
}

const btnBack = () => {
  router.push({ name: 'CartPage' })
}

const btnSubmit = () => {
  api.post('setMemberOrder', {
    totalPayment: fetch.value.totalPayment,
    address: checkoutData.value.address
  }).then((response) => {
    console.log(response)
    checkoutData.value.order = response.data
    sessionStorage.setItem('checkout', JSON.stringify(checkoutData.value))
    router.push({ name: 'SubmitCheckoutPage' })
  })
}

</script>
