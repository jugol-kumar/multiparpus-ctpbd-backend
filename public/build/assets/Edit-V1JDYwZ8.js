import{_ as p,c as l,a as t,w as u,b as d,v as c,b7 as h,H as f,o as m}from"./app-g0Cj44fV.js";const g={name:"Edit",data(){return{from:{name:"",description:"",photo:""},errors:{}}},methods:{uploadFile(s){let e=s.target.files[0],a=new FileReader;a.onload=n=>{this.from.photo=n.target.result},a.readAsDataURL(e)},updateCategory(){let s=this.$route.params.id;axios.patch("/api/category/"+s,this.from).then(e=>{this.from="",this.errors="",Toast.fire({icon:"success",title:e.data.message}),this.$router.push({name:"ManageCategory"})}).catch(e=>{this.errors=e.response.data.errors,Toast.fire({icon:"warning",title:e.response.statusText})})},isLogined(){User.loggedIn()||this.$router.push({name:"Login"})}},created(){this.isLogined();let s=this.$route.params.id;axios.get("/api/category/"+s).then(e=>{this.from=e.data}).catch(e=>{console.log(e.response.data)})}},_={class:"card card-custom"},y=t("div",{class:"card-header"},[t("h3",{class:"card-title"},"Edit Brand")],-1),x={class:"card-body"},b={class:"form-group"},v=t("label",null,"Brand Name",-1),w={key:0,class:"text-danger"},C={class:"form-group"},T=t("label",{for:"exampleTextarea"},"Category Description",-1),B={class:"form-group"},E=t("label",null,"Photo",-1),F=["src"],D=t("div",{class:"card-footer"},[t("button",{type:"submit",class:"btn btn-primary mr-2"},"Submit"),t("button",{type:"reset",class:"btn btn-secondary"},"Cancel")],-1);function L(s,e,a,n,o,i){return m(),l("div",null,[t("div",_,[y,t("form",{class:"form",onSubmit:e[3]||(e[3]=u(r=>i.updateCategory(),["prevent"])),enctype:"multipart/form-data"},[t("div",x,[t("div",b,[v,d(t("input",{type:"text",class:"form-control form-control-solid","onUpdate:modelValue":e[0]||(e[0]=r=>o.from.name=r),placeholder:"Enter employee name..."},null,512),[[c,o.from.name]]),o.errors.name?(m(),l("small",w,h(o.errors.name[0]),1)):f("",!0)]),t("div",C,[T,d(t("textarea",{id:"exampleTextarea",class:"form-control form-control-solid","onUpdate:modelValue":e[1]||(e[1]=r=>o.from.description=r),rows:"3"},null,512),[[c,o.from.description]])]),t("div",B,[E,t("input",{type:"file",class:"form-control",onChange:e[2]||(e[2]=(...r)=>i.uploadFile&&i.uploadFile(...r))},null,32)]),t("img",{src:o.from.photo,alt:"",style:{width:"180px",height:"120px"}},null,8,F)]),D],32)])])}const V=p(g,[["render",L]]);export{V as default};