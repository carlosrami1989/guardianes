<template>
    <div>
      <v-row
        style="font-family: 'Arial Black'; color: black"
        align="center"
        justify="center"
      >
     
        <v-col cols="12" sm="4" align="center" justify="center">
           
          <v-card
            color="transparent"
            rounded="xl"
            class="text-md-center"
            style="color: rgb(255, 212, 76)"
          >
          <br>
            <v-card-title primary-title class="justify-center">
              <h3>
                RECUPERAR CONTRASEÑA
              </h3>
              <span style="font-weight: bold; font-size:x-small;color: white;">
                Ingresa tu correo electrónico para recuperar contraseña. 
                    </span
                    >
            </v-card-title>
           
            <v-card-text>
                <v-select
                    background-color="#FFD44C"
                    rounded
                    filled
                    :items="ListaIdentificacion"
                    v-model="formRegistro.idIdentificacion"
                    item-text="descripcion"
                    item-value="id"
                    persistent-hint
                    single-line
                    label="Tipo Identificación"
                  ></v-select>
                  <span style="font-weight: bold; font-size:small;color: white;">
                Presione enter para verificar su correo
                    </span
                    >
                <v-text-field
                    background-color="#FFD44C"
                    v-model="formRegistro.identificacion"
                    :counter="13"
                    :rules="nameRulesCedula"
                    @keydown="ValidarCedula()"
                    rounded
                    filled
                    label="Nº Documento"
                    required
                  ></v-text-field>
              
                  
                 
                  <v-text-field
                  readonly
                    type="mail"
                    v-model="formRegistro.mail"
                    rounded
                    background-color="#FFD44C"
                    filled
                    label="Correo Electrónico"
                    required
                  ></v-text-field>
              
               
                
               
            </v-card-text>
          
            <v-card-actions class="justify-center">
                <v-btn rounded color="#FFD44C" @click="GrabarRegistro()"> &nbsp;&nbsp;&nbsp; RESTABLECER CONTRASEÑA&nbsp;&nbsp;&nbsp;</v-btn>
              
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
        formRegistro: {
        idIdentificacion: 0,
        identificacion: 0,
        nombres: "",
        telefono: 0,

        mail: "",
        Password: "",
        ConfirmPassword: "",
        terminos: false,
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
    },
    methods: {
      ValidarCedula() {
      
      try {
        if (
          this.formRegistro.identificacion.length == 10 ||
          this.formRegistro.identificacion.length == 13
        ) {
         
          let url =
            this.$store.getters.getRuta +
            "/modulos/sorteo/copedesa/consulta_usuario_recovery/" +
            this.formRegistro.identificacion;

          axios
            .get(url)
            .then((response) => {
           
              if (response.data.data == null) {
                this.$swal(
                  "Copedesa!!!",
                  "El numero de identificación no se encuentra en nuestras base, tanquea para ser parte del sorte o intenta mas tarde",
                  "info"
                );
                return;
              }else{
                this.formRegistro.mail = response.data.data.mail;

              }
              console.log("liusta", response.data);
            })
            .catch((error) => {
              //Errores de validación
            });
        }
      } catch (error) {}
    },
    GrabarRegistro() {
      try {
       
        
        if (
          this.formRegistro.idIdentificacion == "" ||
          this.formRegistro.idIdentificacion == 0
        ) {
          this.$swal("Copedesa!!!", "Seleccione la Identificacion", "error");
          return;
        }

        if (
          this.formRegistro.identificacion == "" ||
          this.formRegistro.identificacion == 0
        ) {
          this.$swal("Copedesa!!!", "Ingresar Identificación", "error");
          return;
        }

        


        let url =
          this.$store.getters.getRuta +
          "/modulos/sorteo/copedesa/PostRecovery/";
       
        axios
          .post(url, this.formRegistro)
          .then((response) => {
           console.log("correo",response);
              if (response.data.verificacion == true) {
                this.$swal("Copedesa!!!", response.data.mensaje, "success");
               // this.$router.push('/')
                
              }else{
                this.$swal("Copedesa!!!", response.data.mensaje, "error");
              }
          
             
          })
          .catch((error) => {
            console.log("correo error",error);
           
          
            window.location.replace("/");

            
          });
      
        } catch (error) {}
    },
    },
  };
  </script>
   