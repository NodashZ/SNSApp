<template>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <post-message title="投稿フォーム" content="コメントと画像を登録"> </post-message>
            <form @submit.prevent="savepost">

                <div class="form-group">
                    <label for="content">
                        内容
                    </label>
                    <textarea id="content" name="content" class="form-control" rows="4"
                        v-model="post.content" required></textarea>
                </div>
                <div class="form-group">
                    <label for="image">
                        画像
                    </label>
                    <div v-if="imageurl">
                        <img :src="imageurl" width="100%">
                    </div>
                    <input class="form-control" @change="uploadFile" type="file" accept="image/*" required>
                </div>

                <div class="mt-5">
                    <a class="btn btn-secondary" href="/">
                        キャンセル
                    </a>
                    <button type="submit" class="btn btn-primary">
                        投稿する
                    </button>
                </div>

            </form>
        </div>
    </div>
</template>
<script>
import Axios from 'axios'

export default {
    data() {
        return {
            post: {},
            fileInfo:'',
            imageurl:"",
        };
    },
    created() {
        this.post.image = ""
    },
    computed: {
        
    },
    methods: {
        savepost() { 
            let date = new Date()
            this.post.image = date.getTime()  //ユニーク名 this.fileInfo.name

            const formData = new FormData()
            formData.append('file',this.fileInfo)
            formData.append('post',JSON.stringify(this.post))

            let url = `/api/posts`
            if (confirm("送信してよろしいですか？")) {
                Axios.post(url, formData)
                    .then(Response => {
                        //リダイレクト
                        location.href = "/"
                    })
                    .catch(error => { alert(error) })
            }
        },
        uploadFile(event) {
            if (this.imageurl.length){
                URL.revokeObjectURL(this.imageurl);
            }
            this.fileInfo = event.target.files[0];
            if(this.fileInfo != void 0) {
                this.imageurl = URL.createObjectURL(this.fileInfo)
            } else {
                this.imageurl = ""
            }
        }
    }
}

</script>