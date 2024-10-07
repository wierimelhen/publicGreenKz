// const REACT_APP_HOST = "e-dendra.kz";
// const PROTOCOL = "https";

const REACT_APP_HOST = "192.168.1.168:8088";
const PROTOCOL = "http";

const api = {
    // async login(data: FormData) {
    //     const response = await fetch(
    //         `${PROTOCOL}://${REACT_APP_HOST}/api/login_auth`,

    //         {
    //             method: "POST",
    //             body: data,
    //         },
    //     );

    //     const jsonData = await response.json();

    //     const token = response.headers.get("authorization")
    //         ? response.headers.get("authorization")?.toString()
    //         : "";

    //     sessionStorage.setItem("jwt", token ? token : "");

    //     return jsonData;
    // },

    async getDataPark(data: FormData) {
        const response = await fetch(
            `${PROTOCOL}://${REACT_APP_HOST}/api/parks-by-qr`,
            {
                method: "POST",
                body: data,
                headers: {
                    Accept: "application/json",
                    // "Content-Type": "application/json",
                    // Authorization: "Bearer " + sessionStorage.getItem("jwt"),
                },
            },
        );

        const jsonData = await response.json();

        return jsonData;
    },

    async getXYDataTrees(data: FormData) {
        const response = await fetch(
            `${PROTOCOL}://${REACT_APP_HOST}/api/XYtrees`,
            {
                method: "POST",
                body: data,
                headers: {
                    Accept: "application/json",
                    // "Content-Type": "application/json",
                    // Authorization: "Bearer " + sessionStorage.getItem("jwt"),
                },
            },
        );

        const jsonData = await response.json();

        return jsonData;
},


};

export default api;
