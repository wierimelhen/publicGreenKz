import React, { useRef, useEffect, useMemo } from 'react';
import { Canvas } from '@react-three/fiber';
import { OrbitControls, Stats, useGLTF } from '@react-three/drei';
import * as THREE from 'three';
import { Matrix4 } from 'three';

// Загрузка модели дерева
const SuzanneModel = () => {
  const { nodes } = useGLTF('/scenes/tree/tree.gltf'); // Загружаем модель дерева
  console.log(nodes)
  const treeMesh = nodes.AM113_063_Tilia01 as THREE.Mesh;
  const croneMesh = nodes.AM113_063_Tilia01_1 as THREE.Mesh;
  const data = 
  {geometry: treeMesh.geometry, material: treeMesh.material,
geometry_2: croneMesh.geometry, material_2: croneMesh.material}

  return treeMesh.geometry ? data : undefined;
};
// Интерфейс для пропсов компонента InstancedMesh
interface Props {
  count: number;
}

const InstancedMesh = (props: Props) => {
  const meshRef = useRef<THREE.InstancedMesh>(null);
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
  const geometry = SuzanneModel()?.geometry
  const material = SuzanneModel()?.material;

  const geometry_2 = SuzanneModel()?.geometry_2
  const material_2 = SuzanneModel()?.material_2;
  // const material = new THREE.MeshNormalMaterial(); // Или материал из GLTF, если он есть

  useEffect(() => {
    if (meshRef.current && geometry) {
      for (let i = 0; i < props.count; i++) {
        randomizeMatrix(matrix);
        meshRef.current.setMatrixAt(i, matrix);
      }
      meshRef.current.instanceMatrix.needsUpdate = true;
    }
  }, [props.count, randomizeMatrix, matrix, geometry]);

  return (
    <instancedMesh
      ref={meshRef}
      args={[geometry, material, props.count]} // Используем загруженную геометрию и материал
    />
  );
};

const Scene = () => {
  return (
    <>
      <ambientLight intensity={0.5} />
      <pointLight position={[10, 10, 10]} />
      <InstancedMesh count={3000} />
      <OrbitControls autoRotate />
    </>
  );
};

const ThreeScene = () => {
  return (
    <div style={{ width: '60vw', height: '60vh', background: '#fff' }}>
      <Canvas camera={{ position: [0, 0, 50] }}>
        <Stats />
        <Scene />
      </Canvas>
    </div>
  );
};

export default ThreeScene;
