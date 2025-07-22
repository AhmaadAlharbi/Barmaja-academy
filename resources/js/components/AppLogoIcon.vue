<script setup lang="ts">
import type { HTMLAttributes } from 'vue';

defineOptions({
    inheritAttrs: false,
});

interface Props {
    className?: HTMLAttributes['class'];
}

defineProps<Props>();
</script>

<template>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" :class="className" v-bind="$attrs">
        <!-- Graduation Cap -->
        <path fill="currentColor" d="M24 6L6 14v2l18 8 18-8v-2L24 6z" />
        <path fill="currentColor" opacity="0.7" d="M38 17v10c0 4-6.27 7-14 7s-14-3-14-7V17l14 6 14-6z" />

        <!-- Book Stack -->
        <rect x="10" y="30" width="28" height="3" rx="1" fill="currentColor" />
        <rect x="12" y="33" width="24" height="3" rx="1" fill="currentColor" opacity="0.8" />
        <rect x="14" y="36" width="20" height="3" rx="1" fill="currentColor" opacity="0.6" />

        <!-- Decorative Academic Elements -->
        <circle cx="42" cy="20" r="3" fill="currentColor" opacity="0.4" />
        <path d="M41 19h2M42 18v2" stroke="currentColor" stroke-width="0.8" opacity="0.6" />

        <!-- Scholar's Tassel -->
        <path d="M30 16l4 2-1 8-3-2 0-8z" fill="currentColor" opacity="0.5" />

        <!-- Academic Stars -->
        <path d="M8 12l1 2 2-1-1 2 1 1-2-1-2 1 1-1-1-2 2 1z" fill="currentColor" opacity="0.3" />
        <path d="M40 32l0.5 1 1-0.5-0.5 1 0.5 0.5-1-0.5-1 0.5 0.5-0.5-0.5-1 1 0.5z" fill="currentColor" opacity="0.3" />
    </svg>
</template>