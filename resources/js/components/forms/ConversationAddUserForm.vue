<template>
    <form action="#">
          <div class="form-group">
              <input type="text" id="users-add" placeholder="Start typing to find users" class="form-control">
          </div>
    </form>
</template>

<script>
import {userautocomplete} from "../../helpers/autocomplete";
import {mapGetters,mapActions} from 'vuex';
export default {
    name: "ConversationAddUserForm",

    computed:mapGetters({
        conversation:'currentConversation'
    }),

    methods:{
        ...mapActions([
            'addConversationUsers'
        ])
    },

    mounted() {
        let users =  userautocomplete('#users-add').on('autocomplete:selected', (e, selection) =>{

            this.addConversationUsers({
                id:this.conversation.id,
                recipientIds:[selection].map((r) =>{
                    return r.id
                })
            })
            users.autocomplete.setVal('')
        })
    },

}
</script>

<style scoped>

</style>
