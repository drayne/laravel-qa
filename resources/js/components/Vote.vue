<template>
    <div class="d-flex flex-column vote-controls">
        <a @click.prevent="voteUp" :title="title('up')" class="vote-up" :class="classes">
            <i class="fas fa-caret-up fa-3x"></i>
        </a>

        <span class="votes-count">{{ count }}</span>

        <a @click.prevent="voteDown" :title="title('down')" class="vote-down" :class="classes">
            <i class="fas fa-caret-down fa-3x"></i>
        </a>

        <favorite v-if="name === 'question'" :question="model"></favorite>

        <accept v-else :answer="model"></accept>

    </div>

</template>

<script>
    import Favorite from "./Favorite";
    import Accept from "./Accept";

    export default {
        name: "Vote",
        components: {Favorite, Accept},
        props: ['name', 'model'],
        data() {
            return {
                count: this.model.votes_count || 0,     //ako je this.model.votes_count null - ili nije setovan - bice 0
                id: this.model.id
            }
        },
        computed: {
            classes() {
                return this.signedIn ? '' : 'off';
            },
            endpoint() {
                return `/${this.name}s/${this.id}/vote`; //questionS answerS zato s ostaje
            }
        },
        methods: {
            title(voteType) {
                let titles = {
                    up: `This ${this.name} is useful`,
                    down: `This ${this.name} is not useful`
                };
                return titles[voteType]
            },
            voteUp() {
                this.vote(1);
            },
            voteDown() {
                this.vote(-1);
            },
            vote(vote) {
                if(!this.signedIn) {
                    this.$toast.warning(`Please login to vote the ${this.name}`, 'Warning', {
                        timeout: 3000,
                        position: 'bottomLeft'
                    });
                    return; //da bi iskocilo
                }
                axios.post(this.endpoint, {
                    vote    //isto sto i vote: vote
                })
                    .then(res => {
                        this.$toast.success(res.data.message, "Success", {
                            timeout: 3000,
                            position: 'bottomLeft'
                        });
                        //this.count += vote; //ovako je uvecavalo svakim klikom
                        this.count = res.data.votesCount;
                    })
            }
        },
    }
</script>
