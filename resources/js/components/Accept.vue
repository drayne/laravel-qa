<template>
    <div>
        <a v-if="canAccept" :class="classes" @click.prevent="create()" title="Mark this answer as best">
            <i class="fas fa-check fa-2x"></i>
        </a>

        <a v-if="accepted " class="classes" title="Best answer">
            <i class="fas fa-check fa-2x"></i>
        </a>
    </div>
</template>

<script>
    import EventBus from '../event-bus'
    export default {
        name: "Accept",
        props: ['answer'],
        data() {
            return {
                isBest: this.answer.is_best,
                id: this.answer.id
            }
        },
        methods: {
            create() {
                axios.post(`/answers/${this.id}/accept`)
                    .then(res => {
                        this.$toast.success(res.data.message, "Success", {
                            timeout: 3000,
                            position: 'bottomLeft'
                        });
                        this.isBest = true;

                        EventBus.$emit('accepted', this.id);
                    })
            }
        },
        computed: {
            canAccept() {
                return this.authorize('accept', this.answer);
            },
            accepted(){
                return !this.canAccept && this.isBest
            },
            classes(){
                return [
                    'mt-2',
                    this.isBest ? 'vote-accepted' : ''
                ]
            }
        },
        created() {
            EventBus.$on('accepted', id => {
                this.isBest = id === this.id
            })
        }
    }
</script>
