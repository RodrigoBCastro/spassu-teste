<script setup>
defineProps({
  title: { type: String, required: true },
  size: { type: String, default: 'md' },
})
</script>

<template>
  <Teleport to="body">
    <div class="modal-overlay">
      <div class="modal-box" :class="`modal-box--${size}`">
        <div class="modal-box__header">
          <h5 class="modal-box__title">{{ title }}</h5>
        </div>
        <div class="modal-box__body">
          <slot />
        </div>
        <div class="modal-box__footer">
          <slot name="footer" />
        </div>
      </div>
    </div>
  </Teleport>
</template>
