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
          <v-card-title primary-title class="justify-center" style="line-height: 1em;">
            <h3>REGÍSTRATE</h3>
            <span style="font-weight: bold; font-size: x-small; color: white">
              Regístrarte para poder ingresar tus códigos de la promo “Hinchas
              en Marcha”
            </span>
          </v-card-title>

          <v-card-text>
            <v-row>
              <v-col>
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
              </v-col>
              <v-col>
                <v-text-field
                  background-color="#FFD44C"
                  v-model="formRegistro.identificacion"
                  :counter="13"
                  :rules="nameRulesCedula"
                  rounded
                  @keydown="ValidarCedula()"
                  filled
                  label="Nº Documento"
                  required
                ></v-text-field>
              </v-col>
            </v-row>

            <v-text-field
              background-color="#FFD44C"
              v-model="formRegistro.nombres"
              :rules="nameRules"
              rounded
              filled
              label="Nombre Apellido/Razon Social"
              required
            ></v-text-field>

            <v-text-field
              type="number"
              v-model="formRegistro.telefono"
              rounded
              background-color="#FFD44C"
              filled
              label="Número de Telefónico"
              required
            ></v-text-field>

            <v-text-field
              type="mail"
              v-model="formRegistro.mail"
              rounded
              background-color="#FFD44C"
              filled
              label="Correo Electrónico"
              required
            ></v-text-field>

            <v-text-field
              type="password"
              v-model="formRegistro.Password"
              rounded
              background-color="#FFD44C"
              filled
              label="Crear Contraseña"
              required
            ></v-text-field>

            <v-text-field
              type="password"
              v-model="formRegistro.ConfirmPassword"
              rounded
              background-color="#FFD44C"
              filled
              label="Repetir Contraseña"
              required
            ></v-text-field>

            <v-row>
              <v-col align="center" justify="center">
                <v-checkbox
                  outline
                  color="#FFD44C"
                  v-model="formRegistro.terminos"
                >
                  <template v-slot:label>
                    <div @click.stop="" style="text-align: center;color:#FFD44C;">
                      Acepta
                      <a href="#" style=" color:black;" @click.prevent="terminos = true">términos</a>
                      y condiciones.
                    </div>
                  </template>
                </v-checkbox>
              </v-col>
            </v-row>
          </v-card-text>

          <v-card-actions class="justify-center">
            <v-btn rounded color="#FFD44C" @click="GrabarRegistro()">
              &nbsp;&nbsp;&nbsp; REGISTRARSE&nbsp;&nbsp;&nbsp;</v-btn
            >
          </v-card-actions>
          <!-- ///aqui va el modal -->
          <v-dialog v-model="terminos" width="80%">
            <v-card>
              <v-card-title class="text-h6">  POLITICA DE SEGURIDAD DE LA INFORMACIÓN Y
                PROTECCIÓN DE DATOS PERSONALES </v-card-title>
              <embed src="/pdf/politicadp.pdf" type="application/pdf" width="100%" height="600px">
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn text color="purple" @click="terminos = false">
                  Ok
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
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
      terminos: false,
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
        (v) => (v && v.length <= 50) || "Campo minimo 50 caracteres",
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
            "/modulos/sorteo/copedesa/consulta_usuario/" +
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
               
              }else{
                
                this.formRegistro.nombres = response.data.data.nombre;
              }
              //console.log("liusta", response.data);
            })
            .catch((error) => {
              //Errores de validación
            });
        }
      } catch (error) {}
    },
    GrabarRegistro() {
      try {
        this.ValidarCedula();

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

        if (
          this.formRegistro.nombres == "" ||
          this.formRegistro.nombres == 0
        ) {
          this.$swal("Copedesa!!!", "Ingresar el nombre", "error");
          return;
        }


        if (
          this.formRegistro.telefono == "" ||
          this.formRegistro.telefono == 0
        ) {
          this.$swal("Copedesa!!!", "Ingresar el numero de telefono", "error");
          return;
        }


        if (
          this.formRegistro.mail == "" ||
          this.formRegistro.mail == 0
        ) {
          this.$swal("Copedesa!!!", "Ingresar el correo electrónico", "error");
          return;
        }
        if (
          this.formRegistro.Password == "" ||
          this.formRegistro.Password == 0
        ) {
          this.$swal("Copedesa!!!", "Ingresar la Contraseña", "error");
          return;
        }
        if (
          this.formRegistro.ConfirmPassword == "" ||
          this.formRegistro.ConfirmPassword == 0
        ) {
          this.$swal("Copedesa!!!", "Ingresar la verificación", "error");
          return;
        }
        if (
          this.formRegistro.terminos == false
        ) {
          this.$swal("Copedesa!!!", "Acepte terminos de condiciones", "error");
          return;
        }
        if (
          this.formRegistro.Password != this.formRegistro.ConfirmPassword
        ) {
          this.$swal("Copedesa!!!", "La contraseña no es la misma de la Verificación", "error");
          return;
        }


        let url =
          this.$store.getters.getRuta +
          "/modulos/sorteo/copedesa/PostIngresar/";
       
        axios
          .post(url, this.formRegistro)
          .then((response) => {
            
              if (response.data.verificacion == true) {
                this.$swal("Copedesa!!!", response.data.data, "success");
                this.$router.push('/')
                
              }else{
                this.$swal("Copedesa!!!", response.data.data, "error");
              }
         
            
          })
          .catch((error) => {
            this.mensajeAler(true, true);
            this.$swal("Copedesa!!!", error, "error");
            window.location.replace("/");

            
          });
      } catch (error) {}
    },
    showAlert() {
      // Use sweetalert2
      // this.$swal('Hello Vue world!!!',confirmButtonColor);
      this.$swal("Hello Vue world!!!", "codigo 2", "error");
      //       this.$swal.fire({
      //   title: 'Error!',
      //   text: 'Do you want to continue',
      //   icon: 'error',
      //   confirmButtonText: 'Cool'
      // })
    },
    saludar() {},
  },
};
</script>
   