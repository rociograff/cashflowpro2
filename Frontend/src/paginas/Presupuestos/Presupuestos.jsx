
import React, { useState, useEffect } from "react";
import axios from "axios";
import { Navbar } from "../../components/Navbar/Navbar";
import Footer from "../../Components/Footer/Footer";

function Presupuestos() {
  /**
   * Se declaran múlticos estados usando el hook useState. Estos estados se utilizan para almacenar 
   * diferentes datos, como el ID del usuario, la fecha seleccionada, el presupuesto, indicadores de carga, 
   * movimientos financieros, totales y fechas de inicio y fin.
   */
  const [userId, setUserId] = useState(null);
  const [fechaSeleccionada, setFechaSeleccionada] = useState(
    new Date().toJSON().slice(0, 10)
  );
  const [presupuesto, setPresupuesto] = useState([]);
  const [loading, setLoading] = useState(true);
  const [movimientos, setMovimientos] = useState({});
  const [totales, setTotales] = useState({});
  const [fechaDesde, setFechaDesde] = useState("");
  const [fechaHasta, setFechaHasta] = useState("");

  /**
   * Se define una función handleSubmit que se ejecuta cuando se envía un formulario. Esta función construye 
   * una URL para realizar una solicitud a una API en función de los valores de los estados userId, 
   * fechaSeleccionada, fechaDesde y fechaHasta. Luego, hace una solicitud GET a la API utilizando la 
   * biblioteca Axios y almacena los resultados en los estados correspondientes.
   */
  const handleSubmit = async (e) => {
    e.preventDefault();
    let url = `/api/presupuestos/${encodeURIComponent(
      userId
    )}/${encodeURIComponent(fechaSeleccionada)}/`;

    if (fechaDesde !== "") {
      url += `?fechaDesde=${encodeURI(fechaDesde)}`;
    }

    if (fechaHasta !== "") {
      if (fechaDesde !== "") {
        url += `&fechaHasta=${encodeURI(fechaHasta)}`;
      } else {
        url += `?fechaHasta=${encodeURI(fechaHasta)}`;
      }
    }

    const { data, error } = await axios.get(url);

    const {
      ingresos,
      ahorro,
      inversiones,
      gastos,
      prestamos,
      totalIngresos,
      totalAhorros,
      totalInversiones,
      totalGastos,
      totalPrestamos,
      totalHistorial,
    } = data;

    setPresupuesto({
      ingresos,
      ahorro,
      inversiones,
      gastos,
      prestamos,
    });
    setMovimientos({
      totalIngresos,
      totalAhorros,
      totalInversiones,
      totalGastos,
      totalPrestamos,
    });
    setTotales({
      totalIngresos,
      totalAhorros,
      totalInversiones,
      totalGastos,
      totalPrestamos,
      totalHistorial,
    });

    console.log(data);
  };

  /**
   * Se utiliza el hook useEffect para realizar una solicitud inicial a la API de Laravel cuando el 
   * componente se monta. Esto sucede cuando la página se carga por primera vez. La solicitud se realiza 
   * para obtener datos del presupuesto del mes actual y se almacenan en los estados.
   */
  useEffect(() => {
    const authUser = JSON.parse(localStorage.getItem("auth_usuario"));
    // Verificar si user_id y fechaSeleccionada están definidos
    if (!authUser && !fechaSeleccionada) {
      console.error("user_id y/o fechaSeleccionada no están definidos");
      setLoading(false);
      return;
    }

    setUserId(authUser.id);

    // Hacer una solicitud GET a la API de Laravel para obtener los datos del presupuesto del mes actual
    axios
      .get(`/api/presupuestos/${authUser.id}/${fechaSeleccionada}`)
      .then((response) => {
        console.log(response.data);
        const {
          ingresos,
          ahorro,
          inversiones,
          gastos,
          prestamos,
          totalIngresos,
          totalAhorros,
          totalInversiones,
          totalGastos,
          totalPrestamos,
          totalHistorial,
        } = response.data;
        setPresupuesto({
          ingresos,
          ahorro,
          inversiones,
          gastos,
          prestamos,
        });
        setMovimientos({
          totalIngresos,
          totalAhorros,
          totalInversiones,
          totalGastos,
          totalPrestamos,
        });
        setTotales({
          totalIngresos,
          totalAhorros,
          totalInversiones,
          totalGastos,
          totalPrestamos,
          totalHistorial,
        });
        setLoading(false);
      })
      .catch((error) => {
        console.error("Error al obtener el presupuesto:", error);
        setLoading(false);
      });
  }, []);
  return (
    <div>
      <Navbar />
      {/* El componente renderiza elementos HTML y JSX que representan la interfaz de usuario de la página. 
      Incluye un formulario con campos para seleccionar las fechas desde y hasta, así como botones para 
      realizar la búsqueda. */}
      <div className="body-presupuestos ">
        <div className="titulo-seccion">
          <h2>Listado de presupuestos</h2>
        </div>
        <form
          className="row col-6 offset-3 row-cols-lg-auto gap-3 d-flex justify-content-center align-items-center"
          onSubmit={handleSubmit}
        >
          <div className="col-12">
            <label>Fecha Desde</label>
            <input
              className="form-control"
              id="fecha_desde"
              name="fecha_desde"
              type="date"
              value={fechaDesde}
              onChange={(e) => setFechaDesde(e.currentTarget.value)}
            />
          </div>
          <div className="col-12">
            <label>Fecha Hasta</label>
            <input
              className="form-control"
              id="fecha_hasta"
              name="fecha_hasta"
              type="date"
              value={fechaHasta}
              onChange={(e) => setFechaHasta(e.currentTarget.value)}
            />
          </div>
          <button
            type="submit"
            className="btn btn-danger col-12"
            style={{ marginTop: "2.5rem" }}
          >
            Buscar
          </button>
        </form>
        {/* Dependiendo del estado de carga (loading), se muestra un mensaje de carga o se muestra la información 
        del presupuesto en función de los datos obtenidos. */}
        {loading && <p>Cargando datos...</p>}
        {!loading && presupuesto && (
          <div className="row d-flex gap-2 justify-content-center">
            {/* Se itera a través de los datos de presupuesto y totales y se muestran en tablas HTML. */}
            {Object.entries(presupuesto).map((data, index) => {
              return (
                <div className="col col-6" key={index}>
                  {data[0] === "ingresos" && (
                    <h2 className="text-success text-capitalize">{data[0]}</h2>
                  )}
                  {data[0] === "inversiones" && (
                    <h2 className="text-danger text-capitalize">{data[0]}</h2>
                  )}
                  {data[0] === "gastos" && (
                    <h2 className="text-danger text-capitalize">{data[0]}</h2>
                  )}
                  {data[0] === "prestamos" && (
                    <h2 className="text-danger text-capitalize">{data[0]}</h2>
                  )}
                  {data[0] === "ahorro" && (
                    <h2 className="text-danger text-capitalize">{data[0]}</h2>
                  )}
                  <table className="table">
                    <thead>
                      <tr>
                        <th>Descripción</th>
                        <th>Importe</th>
                        <th>Entidad</th>
                      </tr>
                    </thead>
                    <tbody>
                      {data[1].map((item) => (
                        <tr>
                          <td>{item.descripcion ?? item.deudor}</td>
                          <td>{item.importe}</td>
                          <td>
                            {item.entidad === "" || !item.entidad
                              ? "-"
                              : item.entidad}
                          </td>
                        </tr>
                      ))}
                    </tbody>
                  </table>
                </div>
              );
            })}
          </div>
        )}
        {!loading && totales && (
          <div className="row d-flex gap-2 justify-content-center">
            <div className="titulo-seccion row">
              <h2>Totales</h2>
            </div>
            <div className="col col-6">
              <table className="table">
                <thead>
                  <tr>
                    <th>Categoría</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tbody>
                  {Object.entries(totales).map(([categoria, total], index) => (
                    <tr key={index}>
                      <td>{categoria}</td>
                      <td>{total}</td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          </div>
        )}
      </div>

      <Footer />
    </div>
  );
}

export default Presupuestos;