import conversation from "./conversation";
import api from '../api/api'


const state = {

    conversations:[],

    loadingConversations:false
}

const getters = {

    allConversations(state) {

        return state.conversations;
    },

    loadingConversations(state) {

        return state.loadingConversations;
    }
}

const actions = {

    getConversations({dispatch, commit}, page) {

            commit('setConversationLoading', true)

            api.getConversations(1).then((response) =>{

                commit('setConversations', response.data.data)
                commit('setConversationLoading', false)

                Echo.private('user.' + Laravel.user.id)
                    .listen('ConversationCreated', (e) =>{

                      commit('prependToConversation', e.data)
                    })
                    .listen('ConversationReplyCreated', (e) =>{

                        commit('prependToConversation',e.data.parent.data)
                    })
            })

    }
}

const mutations = {

    setConversations(state, conversations ) {

        state.conversations = conversations
    },

    setConversationLoading(state, status) {

        state.loadingConversations = status
    },

    prependToConversation(state, conversation) {

        state.conversations = state.conversations.filter((c) =>{

            return c.id !== conversation.id
        })

        state.conversations.unshift(conversation)
    },

    updateConversationInList(state, conversation) {

        state.conversations = state.conversations.map((c) =>{

            if(c.id === conversation.id) {
                return conversations;

            }
            return c;
        })
    }
}

const modules = {

    conversation:conversation
}

export default {
    state,
    getters,
    mutations,
    actions,
    modules
}
