import React, { useRef, useEffect, useMemo } from 'react';
import { Canvas } from '@react-three/fiber';
import { OrbitControls, Stats, useGLTF } from '@react-three/drei';
import * as THREE from 'three';
import { Matrix4 } from 'three';

// Загрузка модели дерева
const SuzanneModel = () => {
  const { nodes } = useGLTF('/scenes/tree/tree.gltf');
  
  // Получаем ствол и крону как отдельные меши
  const treeMesh = nodes.AM113_063_Tilia01 as THREE.Mesh;
  const croneMesh = nodes.AM113_063_Tilia01_1 as THREE.Mesh;

  return {
    treeGeometry: treeMesh.geometry,
    treeMaterial: treeMesh.material,
    croneGeometry: croneMesh.geometry,
    croneMaterial: croneMesh.material,
  };
};
// Интерфейс для пропсов компонента InstancedMesh
interface Props {
  count: number;
}

const InstancedMesh = (props: Props) => {
  const meshRef = useRef<THREE.InstancedMesh>(null);
  const croneRef = useRef<THREE.InstancedMesh>(null);

    const matrix = useMemo(() => new Matrix4(), []);

  // Функция для рандомизации матриц
  const randomizeMatrix = useMemo(() => {
    const position = new THREE.Vector3();
    const quaternion = new THREE.Quaternion();
    const scale = new THREE.Vector3();
    return (matrix: THREE.Matrix4) => {
      position.set(Math.random() * 400 - 200, 0, Math.random() * 400 - 200);
      scale.setScalar(1); // Можем поменять масштаб при необходимости
      matrix.compose(position, quaternion, scale);
    };
  }, []);

  // Загружаем геометрию и материал из модели дерева
  const { treeGeometry, treeMaterial, croneGeometry, croneMaterial } = SuzanneModel();

  // const material = new THREE.MeshNormalMaterial(); // Или материал из GLTF, если он есть

  useEffect(() => {
    if (meshRef.current && croneRef.current && treeGeometry && croneGeometry) {
      for (let i = 0; i < props.count; i++) {
        randomizeMatrix(matrix);
        // Применяем матрицу к стволу
        meshRef.current.setMatrixAt(i, matrix);
        // Применяем матрицу к кроне
        croneRef.current.setMatrixAt(i, matrix);
      }
      meshRef.current.instanceMatrix.needsUpdate = true;
      croneRef.current.instanceMatrix.needsUpdate = true;
    }
  }, [props.count, randomizeMatrix, matrix, treeGeometry, croneGeometry]);


  return (
    <>
      {/* Инстансируем ствол дерева */}
      <instancedMesh
        ref={meshRef}
        args={[treeGeometry, treeMaterial, props.count]} // Используем загруженную геометрию и материал для ствола
      />

      {/* Инстансируем крону дерева */}
      <instancedMesh
        ref={croneRef}
        args={[croneGeometry, croneMaterial, props.count]} // Используем загруженную геометрию и материал для кроны
      />
    </>
  );
};

const Ground = () => {
  return (
    <mesh rotation={[-Math.PI / 2, 0, 0]} position={[0, 0, 0]}>
      <planeGeometry args={[10000, 10000]} /> 
      <meshBasicMaterial color="#5e9759" /> {/* Задаем цвет земли (зеленый, например) */}
    </mesh>
  );
};

const Scene = () => {
  return (
    <>
      <ambientLight intensity={0.5} />
      <pointLight position={[10, 10, 10]} />
      <InstancedMesh count={3000} />
      <Ground />
      <OrbitControls         
        autoRotate
        minPolarAngle={Math.PI / 3}  // Ограничиваем минимальный угол опускания (60 градусов)
        maxPolarAngle={Math.PI / 2.2} // Ограничиваем максимальный угол поднятия (примерно 82 градусов)
        maxDistance={500}  // Максимальное отдаление камеры
        minDistance={50}   // Минимальное приближение камеры
        enablePan={false} // Отключаем панорамирование
  />
    </>
  );
};

const ThreeScene = () => {
  return (
    <div style={{ width: '60vw', height: '60vh', background: '#748f9b' }}>
      <Canvas camera={{ position: [1, 1, 50] }}>
        <Stats />
        <Scene />
      </Canvas>
    </div>
  );
};

export default ThreeScene;
