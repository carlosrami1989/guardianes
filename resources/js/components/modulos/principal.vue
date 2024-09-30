<template>
    <div>
      <v-row
        style="font-family: 'Arial Black'; color: black"
        align="center"
        justify="center"
      >
        <v-col   sm="8"    align="center" justify="center">
          <v-card
            color="transparent"
           
            class="text-md-center"
            style="color: rgb(255, 212, 76)"
          >
            
            <v-card-title primary-title class="justify-center" style="">
              
            <span style=" line-height: 1em;"><h2> HOLA, ( {{ usuario.nombre }})</h2> </span>  
              
            </v-card-title>  
            <v-card-title primary-title class="justify-center">
              <span style="font-weight: bold; font-size: small;color: white;line-height: 1em;">Tu correo electrónico es {{ usuario.mail }} <br>
                INGRESO DE CÓDIGOS NUEVOS <br>VERIFICA / INGRESA TUS CÓDIGOS SEPARADOS POR COMAS </span>

            </v-card-title>  
            
           
            <v-card-text>
              <v-textarea
               background-color="white"
      color="black"
          outlined
          
          
          v-model="validacion.textCodigo"
        ></v-textarea>

            </v-card-text>
           <v-card-title primary-title class="justify-center white--text">
           
              <v-btn  color="#FFD44C" rounded @click="InsertCodigo()">
                <span style="color: black; font-family: 'Arial Black'"
                  >VALIDAR CÓDIGOS</span
                ></v-btn
              >
          
            </v-card-title>
            <v-card-actions class="justify-center">
              <v-row>
                <v-col>
                  <router-link  to="/actualizar"  >
                    <v-btn rounded color="#FFD44C" > &nbsp;&nbsp;&nbsp;   ACTUALIZAR DATOS&nbsp;&nbsp;&nbsp;</v-btn>
                  </router-link>
                 
                </v-col>
                <v-col>
                  <router-link  to="/actualizar_password"  >
                  <v-btn rounded color="#FFD44C">CAMBIAR CONTRASEÑA</v-btn>
                </router-link>
                </v-col>
                <v-col>
                  <v-btn rounded color="#FFD44C" @click="cerrarSession()">CERRAR SESIÓN</v-btn>
                </v-col>
              </v-row>
            </v-card-actions>
          </v-card>
          <!-- <span
            >Para reservas mayores a 10 personas, por favor contáctarse al número
            xxxxxxxxxx.</span -->
        </v-col>
      </v-row>
  
      <!-- <dash-menu> </dash-menu> -->
    </div>
  </template>
  
  <script>
import { forEach } from 'lodash';

  export default {
    props: {
      user: {
        type: Object,
      },
      invert: {
        type: Object,
      },
    },
    name: "PageIndex",
    data() {
      return {
        ListaIdentificacion: [
          { id: "1", descripcion: "RUC" },
          { id: "2", descripcion: "CEDULA" },
        ],
        formInicio: {
          idIdentificacion: 0,
          identificacion: 0,
          password: "",
        },
        ListaCodigos: [],
        usuario:{
          idIdentificacion:0,
          identificacion:0,
          nombre:"",
          telefono:"",
          mail:"",
        },
        validacion:{
          textCodigo:"",
        },
        rules: {
          age: [
            (val) =>
              val < 11 ||
              `Si la cantidad es mayor a 10 personas es obligatorio cancelar la reserva`,
          ],
        },
        nameRulesCedula: [
          (v) => !!v || "Campo es Requerido",
          (v) => (v && v.length <= 13) || "Campo minimo 10 caracteres",
        ],
        nameRulesTelefono: [],
        nameRules: [
          (v) => !!v || "Campo es Requerido",
          (v) => (v && v.length <= 25) || "Campo minimo 25 caracteres",
        ],
        ItemEstacion: 0,
        vtext: "",
        valuecarlos: "",
        valuejonu: "",
        form: {
          id: "",
        },
      };
    },
    components: {},
    mounted() {
      // window.Echo = new Echo({
      //   broadcaster: 'pusher',
      //   key: 'ASDASD2121',
      //   wsHost: window.location.hostname,
      //   wsPort: 6001,
      //   disableStats: true,
      //   //enabledTransports: ['ws', 'wss'], // <-- only use ws and wss as valid transports
      //    forceTLS: false,
      // })
      // let that = this;
      // window.Echo.channel('home').listen('NewMessage', (e) => {
      //   that.vtext = e.message;
      //   console.log(e.message)
      // })
     this.generar();
    },
    methods: {
      cerrarSession(){
        this.ListaCodigos= [];
        this.usuario= {};
        window.location.replace("/");
      },
        generar() {
      try {
        console.log("usuario", this.$store.usuario);
        if (this.$store.usuario.length != 0) {
          this.usuario.idIdentificacion = this.$store.usuario.idIdentificacion;
          this.usuario.identificacion = this.$store.usuario.identificacion;
          this.usuario.nombre = this.$store.usuario.nombre;
          this.usuario.telefono = this.$store.usuario.telefono;
          this.usuario.mail = this.$store.usuario.mail;
          this.ConsultaCodigos();
        } else {
          this.$router.push("/");
        }
      } catch (error) {
        this.$router.push("/");
      }
    },
    InsertCodigo(){
      try {
          
    
  
          let url =
            this.$store.getters.getRuta +
            "/modulos/sorteo/copedesa/InsertCodigos/";
         
          axios
            .post(url, this.usuario)
            .then((response) => {
              
                if (response.data.verificacion == true) {
                  this.$swal("Copedesa!!!", response.data.mensaje, "success");
                    
                    
                   
                   
                  //  response.data.data.forEach(element => {
                  //   codigos_string += element.codigo+",";
                  //  });
                   
   
                }else{
                  this.$swal("Copedesa!!!", response.data.data, "error");
                }
           
              
            })
            .catch((error) => {
              console.log("error",error);
              this.$swal("Copedesa!!!", error, "error");
              
  
              
            });
        } catch (error) {

        }
    },
      ConsultaCodigos() {
        try {
          
    
  
          let url =
            this.$store.getters.getRuta +
            "/modulos/sorteo/copedesa/PostVerificacionCodigo/";
         
          axios
            .post(url, this.usuario)
            .then((response) => {
              
                if (response.data.verificacion == true) {
                  this.$swal("Copedesa!!!", response.data.mensaje, "success");
                    
                    
                   
                   var codigos_string = "";
                  for (let index = 0; index < response.data.data.length; index++) {
                    let objeto = {};
                    codigos_string += response.data.data[index].codigo+",";
                    objeto.identificacion = response.data.data[index].identificacion;
                    objeto.establecimiento = response.data.data[index].establecimiento;
                    objeto.codigo = response.data.data[index].codigo;
                    objeto.secuencial = response.data.data[index].secuencial;
                    this.ListaCodigos.push(objeto);
                   
                    this.ListaCodigos.push(objeto);
                   
                    
                  }
                  //  response.data.data.forEach(element => {
                  //   codigos_string += element.codigo+",";
                  //  });
                   this.validacion.textCodigo = codigos_string;
                   console.log("listascodigos",this.ListaCodigos);
   
                }else{
                  this.$swal("Copedesa!!!", response.data.data, "error");
                }
           
              
            })
            .catch((error) => {
              console.log("error",error);
              this.$swal("Copedesa!!!", error, "error");
              
  
              
            });
        } catch (error) {}
      },
      saludar() {
        // axios.post('/user', {
        //   firstName: 'Fred',
        //   lastName: 'Flintstone'
        // })
        // .then(function (response) {
        //   console.log(response);
        // })
        // .catch(function (error) {
        //   console.log(error);
        // });
        // let that = this;
        //  let url ='http://192.168.8.73:8000/api/saluda2/';
        //             axios.post(url,this.form)
        //             .then(function(response) {
        //                  that.vtext = esponse.data.saludo;
        //                 console.log(response.data.saludo)
        //             })
        //             .catch(error => {
        //                 Errores de validación
        //             });
        //post('http://192.168.8.73:8000/api/saluda2/'+this.form)
        // const data = await fecth('http://192.168.8.73:8000/api/saluda2/'+this.form)
        // const response = await data.json()
        //console.log(response.saludo)
        // this.vtext = response.saludo;
      },
    },
  };
  </script>
   