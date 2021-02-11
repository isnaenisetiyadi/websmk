<template>
  <div>
    <transition name="modal">
      <div class="modal-mask">
        <div class="modal-wrapper">
          <div class="modal-dialog" role="document">
            <div class="text-center center-spinner">
              <span class="text-spinner">Menunggu...</span>
              <vue-spinner :color="'#fff'" :size="'80px'" />
              <h1><i class="icofont-wink-smile text-white"></i></h1>
            </div>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>
