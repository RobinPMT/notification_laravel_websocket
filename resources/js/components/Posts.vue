<template>
    <div class="container">
        <div class="card p-3">
            Notifications:
            <PostNotify :user="user" :user_notifications="user_notifications" />
        </div>
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Author</th>
                <th scope="col">Post_Action</th>
            </tr>
            </thead>
            <tbody>
            <template v-for="(post, index) in posts" :key="index">
                <tr>
                    <td scope="row">{{index + 1}}</td>
                    <td>{{post.title}}</td>
                    <td>{{post.user.name}}</td>
                    <td>
                        <button type="btn btn-sm btn-info" @click="likePost(post.id)">Like</button>
                    </td>
                </tr>
            </template>
            </tbody>
        </table>
    </div>
</template>

<script>
    import { ref, onMounted } from 'vue';
    import PostNotify from "./PostNotify.vue";
    export default {
        data() {
            return {
                // posts : this.posts,
                // user : Object
            }
        },
        components : {
            PostNotify
        },
        props: {
            posts : Array,
            user : Object,
            user_notifications : Array
        },
        // methods: {
        //     likePost(post_id) {
        //         console.log(post_id)
        //     }
        // },
        setup(props) {
            let posts = ref([]);
            onMounted(() =>{
                posts.value = props.posts;
            });

            function likePost(post_id) {
                axios.post('/post-like',{'post_id':post_id}).then(response => {
                    console.log(response.data);
                });
            }
            return {
                posts,
                likePost
            }
        }

    }
</script>
