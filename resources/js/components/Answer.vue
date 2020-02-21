<script>
    export default {
        name: "Answer.vue",
        props: ['answer'],
        data() {
            return {
                editing: false,
                body: this.answer.body,
                bodyHtml: this.answer.body_html,
                id: this.answer.id,
                questionId: this.answer.question_id,
                beforeEditCache: ''
            }
        },
        computed: {
            isInvalid() {
                return this.body.length < 10
            },
            endpoint() {
                return `/questions/${this.questionId}/answers/${this.id}`
            }
        },
        methods: {
            edit() {
                 this.beforeEditCache = this.body;
                 this.editing = true;
            },
            cancel() {
                this.body = this.beforeEditCache;
                this.editing = false;
            },
            update() {
                this.editing = false;
                axios.patch(this.endpoint, {
                    body: this.body
                })
                    .then(res => {
                        this.editing = false;
                        this.bodyHtml = res.data.body_html;
                        this.$toast.success(res.data.message, 'Success', { timeout: 3000 });
                    })
                    .catch(err => {
                        this.$toast.success(err.response.data.message, 'Error', { timeout: 3000 });
                    });
            },
            destroy() {
            //     if (confirm('Are you sure')) {
            //         axios.delete(this.endpoint)
            //             .then(res => {
            //                 $(this.$el).fadeOut(500, () => {
            //                     this.$toast.success(res.data.message, 'Success', { timeout: 3000 });
            //                 })
            //             })
            //     }


                this.$toast.question('Are you sure', 'Confirm', {
                    timeout: 20000,
                    close: false,
                    overlay: true,
                    displayMode: 'once',
                    id: 'question',
                    zindex: 999,
                    title: 'Hey',
                    message: 'Are you sure about that?',
                    position: 'center',
                    buttons: [
                        ['<button><b>YES</b></button>', (instance, toast) => {
                            axios.delete(this.endpoint)
                                .then(res => {
                                    $(this.$el).fadeOut(500, () => {
                                        this.$toast.success(res.data.message, 'Success', { timeout: 3000 });
                                    })
                                });
                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                        }, true],
                        ['<button>NO</button>', function (instance, toast) {

                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                        }],
                    ],
                });
            }
        },
    }
</script>
