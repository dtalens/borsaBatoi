<template>
  <v-app id="inspire">
    <v-navigation-drawer
      v-model="drawer"
      fixed
      app
    >
    <!-- Menú items-->
      <v-list dense>
        <menu-item
          v-for="item in itemsForRol"
          :key="item.id"
          :icon="item.icon"
          :title="item.text"
          @click="go(item.path)">
        </menu-item>
      </v-list>
    </v-navigation-drawer>
    <v-toolbar color="indigo" dark fixed app>
      <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
      <v-toolbar-title>
        IES Jaume I - Borsa de Treball</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-toolbar-title class="ml-0 pl-3">
        <h2>{{ title }}</h2>
      </v-toolbar-title>
    </v-toolbar>

    <!-- Contenido principal -->
    <v-content>
      <v-container fluid fill-height>
        <v-layout
          justify-center
          align-center
        >
          <router-view 
            @setTitle="setTitle"
            @setRol="setRol">
          </router-view>

        </v-layout>
      </v-container>
    </v-content>

    <v-footer color="indigo" app>
      <span class="white--text">&copy; IES Jaume I 2021</span>
      <v-spacer></v-spacer>
      <span class="white--text"><h2>{{ myName?'Hola '+myName:'' }}</h2></span>
    </v-footer>
  </v-app>
</template>

<script>
  import API from './lib/API';
  import MenuItem from './components/base/MenuItem';

  export default {
    data: () => ({
      drawer: false,
      items: [],
      title: 'Borsa de treball',
      myRol: 9999,
      myName: '',
//      logoBatoi: require('./assets/static/images/logo.png')
    }),
    components: {
      MenuItem,
    },
    created() {
      this.myRol=sessionStorage.user_rol || 9999;
      this.loadData();
    },
    computed: {
      itemsForRol() {
        return this.items.filter(item=>!(item.rol%this.myRol))
      }
    },
    methods: {
      loadData() {
        API.getTable("menu")
          .then(resp => {
              let menu = resp.data.data.filter(item=>item.active);
              // Si tiene subitems sustituimos su código por el item entero 
              menu.filter(item=>item.children).map(item=>{
                  item.children=JSON.parse(item.children);
                  item.children=item.children.map(subitem=>resp.data.find(elem=>elem.id==subitem));
                  return item;
              })
              this.items = menu;
          })
          .catch(err=>console.error(err.data?err.data.message:err.message));
      },
      go(path) {
          this.$router.push(path?path:'/');
      },
      setTitle(title) {
        this.title=title;
      },
      setRol(datos) {
        let rolDescrip='';
        this.myRol=datos?datos.rol:9999;
        switch (this.myRol) {
          case 2: 
            rolDescrip='Administrador';
            break;
          case 3: 
            rolDescrip='Responsable';
            break;
          case 5: 
            rolDescrip='Empresa';
            break;
          case 7: 
            rolDescrip='Alumne';
            break;
        }
        this.myName=datos?rolDescrip+': '+datos.name:'';
      }
    }
  }
</script>
