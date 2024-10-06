import React, { Suspense } from 'react';
import { Canvas } from '@react-three/fiber';
import { OrbitControls, useGLTF } from '@react-three/drei';
import { GLTF } from 'three-stdlib'; // Импортируйте GLTF из three-stdlib
import { TextureLoader } from 'three';
import grassTexture from '/scenes/screenshot.21.jpg'; // пример импорта текстуры

// Компонент для загрузки модели дома
function HouseModel() {
  const { scene } = useGLTF('/scenes/building/scene.gltf') as GLTF;

  return <primitive object={scene} scale={[0.5, 0.5, 0.5]} />;
}

// Компонент для загрузки модели дерева
function TreeModel() {
  const { scene } = useGLTF('/scenes/tree/scene.gltf') as GLTF;
  return <primitive object={scene} scale={[0.01, 0.01, 0.01]} />;
}

// Генерация случайных позиций для деревьев
const generateRandomPositions = (count: number, areaSize: number): [number, number, number][] => {
  const positions: [number, number, number][] = [];
  for (let i = 0; i < count; i++) {
    const x = Math.random() * areaSize - areaSize / 2; // Генерация случайной позиции по оси X
    const z = Math.random() * areaSize - areaSize / 2; // Генерация случайной позиции по оси Z
    positions.push([x, 0, z] as [number, number, number]); // Позиции в формате [x, y, z]
  }
  return positions;
};

// Основная сцена
const Scene: React.FC = () => {
  const treePositions = generateRandomPositions(1500, 100); // 1500 деревьев в области 100x100

  return (
    <Canvas
      shadows
      camera={{ position: [5, 5, 5], fov: 50 }}
    >
      {/* Управление камерой */}
      <OrbitControls />

      {/* Источник света */}
      <ambientLight intensity={0.4} />
      <directionalLight 
        position={[10, 10, 5]} 
        intensity={1.5} 
        castShadow 
      />
      
      {/* Плоскость земли */}
      <mesh rotation={[-Math.PI / 2, 0, 0]} receiveShadow>
        <planeGeometry args={[100, 100]} />
        <meshStandardMaterial color="#e0e0e0" />
      </mesh>

      {/* Домик */}
      <Suspense fallback={null}>
        <HouseModel />
      </Suspense>

      {/* Деревья */}
      <Suspense fallback={null}>
        {treePositions.map((position, index) => (
    <mesh key={index} position={position}>
      <cylinderGeometry args={[0.5, 0.5, 5, 32]} />
      <meshStandardMaterial color="green" />
    </mesh>
        ))}
      </Suspense>

      {/* Столбы */}
      <mesh position={[-3, 0, 3]}>
        <cylinderGeometry args={[0.2, 0.2, 7, 32]} />
        <meshStandardMaterial color="brown" />
      </mesh>
      <mesh position={[3, 0, -3]}>
        <cylinderGeometry args={[0.2, 0.2, 7, 32]} />
        <meshStandardMaterial color="brown" />
      </mesh>

      <mesh rotation={[-Math.PI / 2, 0, 0]} receiveShadow>
        <planeGeometry args={[100, 100]} />
        <meshStandardMaterial map={new TextureLoader().load(grassTexture)} />
      </mesh>
    </Canvas>
  );
};

export default Scene;
