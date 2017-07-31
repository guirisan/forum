<template>
    <div>
        <div v-if="signedIn">
            <div class="form-group">
                <textarea 
                    v-model="body"
                    name="body" 
                    id="body"
                    class="form-control" 
                    rows="5" 
                    required="required" 
                    placeholder="Comment something...">
                        
                </textarea>
            </div>
            <button 
                type="submit" 
                class="btn btn-primary"
                @click="addReply">
                Comment
            </button>
        </div>

        <p class="text-center" v-else>
            Please <a href="/login">sign in</a> to participate
        </p>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                body: ''
            };
        },

        computed: {
            signedIn() {
                return window.App.signedIn;
            }
        },

        methods: {
            addReply() {
                axios.post(location.pathname + '/replies', {body: this.body})
                    .then(({data}) => {
                        this.body = '';

                        flash('Your reply has been posted');

                        this.$emit('created', data);
                    });
            }
        }
    }
</script>
