import VueAvatar from './VueAvatar.vue'
import VueAvatarScale from './VueAvatarScale.vue'

export default {
    data(){
        return {
            choose:false,
            hover:false,
            selected:false
        }
    },
    components: {
        VueAvatar,
        VueAvatarScale
    },
    methods:{
        select(){
            if(this.can){
                this.choose = true
            }
        },
        cancel(){
            this.choose = false
        },
        onChangeScale (scale) {
            this.$refs.vueavatar.changeScale(scale)
        },
        saveClicked(){
            var img = this.$refs.vueavatar.getImageScaled()
            this.image = img.toDataURL()
            this.post();
        },
        onImageReady(scale){
            this.$refs.vueavatarscale.setScale(scale)
            this.selected = true
        }
    }
}