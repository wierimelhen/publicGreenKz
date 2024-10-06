import React from 'react';
import api from "@/api/api";
import { useParams } from 'react-router-dom';
import styles from '@/assets/css/cssModule_1.module.css';
import { useNavigate } from "react-router-dom";
import { responseData_1 } from "@/utils/types/types";

function ParkInfoPage() {
  const routeParams = useParams();  // Захватывает параметры из URL
  const navigate = useNavigate();
  const [parkData, setParkData] = React.useState<responseData_1>({
    park: "---",
    address: "---",
    trees: 0,
    contractors: 0
  });

  const fetchParkData = async () => {
    let formData = new FormData();
    formData.append("token", routeParams['*'] ? routeParams['*'].toString() : '');

    const response = await api.getDataPark(formData);
    console.log(response);

    if (response.error) {
      navigate('/404/qr-code');
    } else {
      setParkData(response);
    }
  };

  React.useEffect(() => {
    fetchParkData();
  }, []);

  return (
    <>
      <div className={styles.box}  onClick={() => navigate('/scene')}>
        <h1>{parkData.park}</h1>
        <p>{parkData.address}</p>
      </div>
      <div className={styles.box}>
        <h3>Деревьев в парке: {parkData.trees}</h3>
        <h3>Больше всего:</h3>
        <h3>Самое старое дерево:</h3>
        <h3>Самое молодое дерево:</h3>
      </div>
      <div className={styles.box}>
        <h3>Организаций обслуживания: {parkData.contractors}</h3>
      </div>
    </>
  );
}

export default ParkInfoPage;
