import React, { useState, useEffect } from "react";
import { useLocation } from "react-router-dom";
import { Navigate } from "react-router-dom";

function GoogleCallback() {
  const [loading, setLoading] = useState(true);
  const [data, setData] = useState({});
  const location = useLocation();

  useEffect(() => {
    fetch(`http://localhost:8000/api/auth/callback${location.search}`, {
      headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
      },
    })
      .then((response) => {
        return response.json();
      })
      .then((responseData) => {
        console.log(responseData); // Muestra la respuesta JSON en la consola
        setLoading(false);
        // setData(responseData);
        localStorage.setItem("auth_token", responseData.access_token);
        localStorage.setItem("nombre", responseData.user.nombre);
        localStorage.setItem("id", responseData.user.id);
      });
  }, [location.search]);

  if (loading) {
    return <DisplayLoading />;
  }

  return <Navigate to="/home" replace={true} />; // Redirige al usuario a la página de inicio
}

function DisplayLoading() {
  return <div>Loading....</div>;
}

export default GoogleCallback;

// import React, { useState, useEffect } from "react";
// import { useLocation } from "react-router-dom";

// function GoogleCallback() {
//   const [loading, setLoading] = useState(true);
//   const [data, setData] = useState({});
//   const [user, setUser] = useState(null);
//   const location = useLocation();

//   // On page load, we take "search" parameters
//   // and proxy them to /api/auth/callback on our Laravel API
//   useEffect(() => {
//     fetch(`http://localhost:8000/api/auth/callback${location.search}`, {
//       headers: {
//         "Content-Type": "application/json",
//         'Accept': "application/json"
//       },
//     })
//       .then((response) => {
//         return response.json();
//       })
//       .then((data) => {
//         setLoading(false);
//         setData(data);
//       });
//   }, []);

//   // Helper method to fetch User data for authenticated user
//   // Watch out for "Authorization" header that is added to this call
//   function fetchUserData() {
//     fetch(`http://localhost:8000/api/user`, {
//       headers: {
//         'Content-Type': "application/json",
//         'Accept': "application/json",
//         'Authorization': "Bearer " + data.access_token,
//       },
//     })
//       .then((response) => {
//         return response.json();
//       })
//       .then((data) => {
//         setUser(data);
//       });
//   }

//   if (loading) {
//     return <DisplayLoading />;
//   } else {
//     if (user != null) {
//       return <DisplayData data={user} />;
//     } else {
//       return (
//         <div>
//           <DisplayData data={data} />
//           <div style={{ marginTop: 10 }}>
//             <button onClick={fetchUserData}>Fetch User</button>
//           </div>
//         </div>
//       );
//     }
//   }
// }

// function DisplayLoading() {
//   return <div>Loading....</div>;
// }

// function DisplayData(data) {
//   return (
//     <div>
//       <samp>{JSON.stringify(data, null, 2)}</samp>
//     </div>
//   );
// }

// export default GoogleCallback;
