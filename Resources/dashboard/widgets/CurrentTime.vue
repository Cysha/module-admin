<template>
    <grid :position="grid">
        <section class="current-time">
            <time class="current-time__content">
                <span class="current-time__date">{{ date }}</span>
                <span class="current-time__time">{{ time }}</span>
            </time>
        </section>
    </grid>
</template>

<script>
import Grid from '../js/mixins/grid.js';
import moment from 'moment';

export default {
    name: 'admin-current-time',
    components: {
        Grid,
    },

    props: {
        dateformat: {
            type: String,
            default: 'DD-MM-YYYY',
        },
        timeformat: {
            type: String,
            default: 'HH:mm:ss',
        },
        grid: {
            type: String,
        },
    },

    computed: {},

    data() {
        return {
            date: '',
            time: '',
        };
    },


    created() {
        this.refreshTime();
    },

    methods: {
        refreshTime() {
            this.date = moment().format(this.dateformat);
            this.time = moment().format(this.timeformat);

            setTimeout(this.refreshTime, 1000);
        },
    },
};

</script>

<style>
  .current-time {
    background-color: rgb(75, 79, 86);
  }
  .current-time__content {
    left: 50%;
    position: absolute;
    top: 50%;
    -webkit-transform: translateX(-50%) translateY(-50%);
    transform: translateX(-50%) translateY(-50%);
    text-align: center;
  }

  .current-time__time {
    font-family: 'Source Sans Pro', sans-serif;
    font-style: normal;
    font-weight: 300;
    font-size: 2em;
    letter-spacing: .05em;
    line-height: 1;
  }

  .current-time__date {
    font-family: 'Source Sans Pro', sans-serif;
    font-style: normal;
    font-weight: 600;
    color: #e83134;
    font-size: 1.1em;
  }
</style>
