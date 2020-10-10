<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-5">
                <conversation-form></conversation-form>
                <conversations></conversations>
            </div>
            <div class="col-sm-7">
                <conversation :id="id"></conversation>
            </div>
        </div>
    </div>
</template>

<script>
    import Conversations from "./Conversations";
    import Conversation from "./Conversation";
    import ConversationForm from "./forms/ConversationForm";
    export default {
        components: {ConversationForm, Conversation, Conversations},

        props:{
            'id':{
                default:null
            }
        },
    }
</script>
