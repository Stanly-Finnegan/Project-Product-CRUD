<template>
  <q-layout>
    <div style="width: calc(100dvw-var(--scrollbar-width)); min-height:100vh;" >
        <h3 class="q-mb-xl">Cart Page</h3>
        <div class="row justify-end"  style="width: 100%;">
          <q-btn color="red" @click="deleteSelected">Delete Selected</q-btn>
        </div>
        <div class="bg-postive q-gutter-y-lg q-mt-xl text-center" style="width: 100%; ">
          <div v-if="fetch.cartTotalPrice === 0" class="text-h3" >No item in cart</div>
          <CartListComponent
          v-for="data in fetch.result"
          :key="data"
          :title="data.title"
          :image="data.image"
          :id="data.id"
          :price="data.price"
          :quantity="data.quantity"
          :totalPrice="data.totalPrice"
          @fetchData="getCart()"
          @checkBoxData="handleCheckBox"

          ></CartListComponent>

          <q-dialog v-model="alertDialog" class="q-px-sm">
            <q-card style="width:60%;">
              <q-card-section class="text-center">
                <h5 style="font-weight: bold;">There is no product selected</h5>
              </q-card-section>

              <q-card-actions align="right">
                <q-btn flat label="OK" @click="alertDialog = false" color="light-blue-10"/>
              </q-card-actions>
            </q-card>
          </q-dialog>
        </div>
    </div>
    <CartBottomActionComponent :totalPrice="fetch.cartTotalPrice"></CartBottomActionComponent>

  </q-layout>
</template>

<script setup>
import { ref } from 'vue'
import CartListComponent from 'src/components/CartListComponent.vue'
import CartBottomActionComponent from 'src/components/CartBottomAction.vue'
import { api } from 'src/boot/axios.js'

const fetch = ref([])
const checkbox = ref([])
const alertDialog = ref(false)

const getCart = () => {
  api.get('getCartMemberData')
    .then((response) => {
      console.log(response.data)
      fetch.value = response.data
    })
}

getCart()

const handleCheckBox = (data) => {
  const index = checkbox.value.findIndex(item => item === data.value)

  data.status === true
    ? checkbox.value.push(data.value)
    : checkbox.value.splice(index, 1)
}

const deleteSelected = () => {
  if (checkbox.value.length === 0) {
    alertDialog.value = true
  } else {
    api.post('deleteSelectedMemberItem', {
      data: checkbox.value
    }).then((response) => {
      getCart()
    }).catch((err) => {
      console.log(err)
    })
  }
}

</script>
