import { useState } from "react";
import Sidebar from "./components/Sidebar";
import Header from "./components/Header";
import MainContent from "./components/MainContent";

const App = () => {
  const [sidebarOpen, setSidebarOpen] = useState(false);
  const [sidebarCollapsed, setSidebarCollapsed] = useState(false);

  const toggleSidebar = () => {
    setSidebarOpen(!sidebarOpen);
  };

  const toggleCollapse = () => {
    setSidebarCollapsed(!sidebarCollapsed);
  };

  return (
    <div className="min-h-screen bg-gray-50">
      {/* Sidebar */}
      <Sidebar
        isOpen={sidebarOpen}
        onToggle={toggleSidebar}
        collapsed={sidebarCollapsed}
        onCollapse={toggleCollapse}
      />

      {/* Main Content */}
      <div
        className={`
        transition-all duration-300 ease-in-out
        lg:ml-64 ${sidebarCollapsed ? "lg:ml-16" : "lg:ml-64"}
        min-h-screen bg-neutral-900
      `}
      >
        <Header onMenuClick={toggleSidebar} />
        <MainContent />
      </div>
    </div>
  );
};

export default App;
