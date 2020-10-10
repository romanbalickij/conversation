<template>
    <div class="panel panel-default">
        <div class="panel-heading">
            All Conversations
        </div>
        <div class="panel-body">
            <div class="loader" v-if="loadingConversations"></div>
            <div class="media" v-for="conversation in allConversations" :key="conversation.id" v-else-if="allConversations.length">
                <div class="media-body">
                    <a href="#" @click.prevent="getConversation(conversation.id)">{{trunc(conversation.body,10)}}</a>
                        <p class="text-muted">
                            You and   {{conversation.participant_count}} others
                        </p>
                        <ul class="list-inline">
                            <li>
                                <img
                                    v-bind:src="user.avatar"
                                    v-bind:title="user.name"
                                    alt="" v-for="user in conversation.users.data">
                            </li>
                            <li>Last reply {{conversation.last_reply_human}}</li>
                        </ul>
                </div>
            </div>
            <div v-else>
                No conversations
            </div>

        </div>
    </div>
</template>

<script>
import trunc  from '../helpers/trunc'
import {mapActions, mapGetters} from 'vuex'
export default {
    name: "Conversations",

    computed:mapGetters({
        allConversations:'allConversations',
        loadingConversations:'loadingConversations'
    }),

    mounted() {
        this.getConversations(1)
    },

    methods:{
        ...mapActions([
            'getConversations',
            'getConversation'
        ]),

        trunc:trunc,
    }

}
</script>

<style scoped>

</style>
