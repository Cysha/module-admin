<template>
    <grid :position="grid">
        <section class="blank">
            <span class="blank__content">
                {{ title }}
            </span>
        </section>
    </grid>
</template>

<script>
import Grid from '../js/mixins/grid.js';

export default {
    name: 'admin-blank',
    components: {
        Grid,
    },
    props: ['grid', 'title'],

    data() {
        return {

        };
    },

    created() {
    }
};
</script>

<style>
    section.blank {
        background-color: rgba(11, 76, 132, 0.7);
    }
</style>
