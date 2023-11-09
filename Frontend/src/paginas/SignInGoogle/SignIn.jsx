import React, { useState, useEffect } from "react";

// function SignIn() {
//   const [loginUrl, setLoginUrl] = useState(null);

//   useEffect(() => {
//     const fetchData = async () => {
//       const res = await fetch("http://localhost:8000/api/auth", {
//         headers: {
//           "Content-Type": "application/json",
//           Accept: "application/json",
//         },
//       });
//       const data = await res.json();
//       setLoginUrl(data.url);
//     };

//     fetchData().catch(console.error('Error'));
//   }, []);

//   return <div>{loginUrl != null && <a href={loginUrl}>Google Sign In</a>}</div>;
// }

function SignIn() {
  const [loginUrl, setLoginUrl] = useState(null);

  useEffect(() => {
    const fetchData = async () => {
      try {
        const res = await fetch("http://localhost:8000/api/auth", {
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
          },
        });
        const data = await res.json();
        setLoginUrl(data.url);

        // Redirige automáticamente a la URL
        if (data.url) {
          window.location.href = data.url;
        }
      } catch (error) {
        console.error("Error:", error);
      }
    };

    fetchData();
  }, []);

  return null; 
}

export default SignIn;
