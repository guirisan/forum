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
    import 'at.js';
    import 'jquery.caret';

    export default {
        data() {
            return {
                body: ''
            };
        },

        mounted() {
            $('#body').atwho({
                at: '@',
                delay: 750,
                callbacks: {
                    remoteFilter: function (query, callback) {
                        $.getJSON("/api/users", {name: query}, function (usernames) {
                            callback(usernames);
                        });
                    }
                }
            });
        },

        methods: {
            addReply() {
                axios.post(location.pathname + '/replies', {body: this.body})
                    .catch(error => {
                        flash(error.response.data, 'danger');
                    })
                    .then(({data}) => {
                        this.body = '';

                        flash('Your reply has been posted');

                        this.$emit('created', data);
                    });
            }
        }
    }
</script>
