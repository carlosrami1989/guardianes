<template>
  <div>
    <v-row
      style="font-family: 'Arial Black'; color: black"
      align="center"
      justify="center"
    >
      <v-col   sm="5"    align="center" justify="center">
        <v-card
          color="transparent"
         
          class="text-md-center"
          style="color: rgb(255, 212, 76)"
        >
          
          <v-card-title primary-title class="justify-center">
            
            <h3>
              INGRESA TUS DATOS PARA<br />
              PARTICIPAR
            </h3>
            <span style="font-weight: bold; font-size: small;color: white;line-height: 1em;">
             
                Recuerda que si eres nuevo debes registrarte para poder ingresar
                tus códigos de la promo <br />
                "Hinchas en Marcha" </span
            >
          </v-card-title>
           
          <v-card-title primary-title class="justify-center white--text">
            <router-link  to="/registrar"  >
          
            <v-btn outlined color="#FFD44C" rounded>
              <span style="color: white; font-family: 'Arial Black'"
                >Registrate aquí</span
              ></v-btn
            >
          </router-link>
          </v-card-title>
          <v-card-text>
            <v-row>
              <v-col>
                <v-select
                  background-color="#FFD44C"
                  rounded
                  filled
                  :items="ListaIdentificacion"
                  v-model="formInicio.idIdentificacion"
                  item-text="descripcion"
                  item-value="id"
                  persistent-hint
                  single-line
                  label="SELECCIONA LA IDENTIFICACION"
                ></v-select>
              </v-col>
            </v-row>
            <v-row>
              <v-col>
                <v-text-field
                  background-color="#FFD44C"
                  v-model="formInicio.identificacion"
                  :counter="13"
                  :rules="nameRulesCedula"
                  rounded
                  filled
                  label="IDENTIFICACION"
                  required
                ></v-text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col>
                <v-text-field
                  type="password"
                  v-model="formInicio.password"
                  rounded
                  background-color="#FFD44C"
                  filled
                  label="CONTRASEÑA"
                  required
                ></v-text-field>
              </v-col>
            </v-row>
          </v-card-text>

          <v-card-actions class="justify-center">
            <v-row>
              <v-col>
               
                  <v-btn rounded color="#FFD44C" @click="GrabarRegistro()"> &nbsp;&nbsp;&nbsp;   INGRESAR&nbsp;&nbsp;&nbsp;</v-btn>
                  
               
              </v-col>
              <v-col>
                <router-link  to="/recovery"  >
                <v-btn rounded color="#FFD44C">RECUPERAR CONTRASEÑA</v-btn>
              </router-link>
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
        identificacion: "",
        password: "",
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
    GrabarRegistro() {
      try {
        
 
        if (
          this.formInicio.idIdentificacion == "" ||
          this.formInicio.idIdentificacion == 0
        ) {
          this.$swal("Copedesa!!!", "Seleccione el tipo Identificacion", "error");
          return;
        }

        if (
          this.formInicio.identificacion == "" ||
          this.formInicio.identificacion == 0
        ) {
          this.$swal("Copedesa!!!", "Ingresar Identificación", "error");
          return;
        }

        if (
          this.formInicio.password == "" ||
          this.formInicio.password == 0
        ) {
          this.$swal("Copedesa!!!", "Ingresar la contraseña", "error");
          return;
        }



        let url =
          this.$store.getters.getRuta +
          "/modulos/sorteo/copedesa/PostLogin/";
       
        axios
          .post(url, this.formInicio)
          .then((response) => {
            
              if (response.data.verificacion == true) {
  //               this.$swal("Copedesa!!!", response.data.mensaje, "success",{showCancelButton: true,
  // confirmButtonColor: "#3085d6",
  // cancelButtonColor: "#d33",
  // confirmButtonText: "Yes, delete it!");
  this.$store.usuario = response.data.data;
  console.log("vuex", this.$store.usuario);
                this.$swal.fire({
                          title: "Bienvenido al portal Copedesa",
                          text:  response.data.mensaje,
                          icon: "success",
                          showCancelButton: true,
                          confirmButtonColor: "#3085d6",
                          cancelButtonColor: "#d33",
                          confirmButtonText: "Continuar"
                        }).then((result) => {
                          if (result.isConfirmed) {
                            this.$router.push('/principal')
                            
                          }
                        });

               
 
              }else{
                this.$swal("Copedesa!!!", response.data.mensaje, "error");
              }
         
            
          })
          .catch((error) => {
            console.log("error",error);
            this.$swal("Copedesa!!!", error, "error");
            

            
          });
      } catch (error) {}
    },
    
  },
};
</script>
 
 