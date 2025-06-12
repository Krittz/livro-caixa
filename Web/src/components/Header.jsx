import { Menu, Settings } from "lucide-react";

const Header = ({ onMenuClick }) => {
  return (
    <header className="bg-neutral-900 border-b border-neutral-800 px-6 py-4">
      <div className="flex items-center justify-between">
        <div className="flex items-center">
          <button
            onClick={onMenuClick}
            className="lg:hidden p-2 rounded-md text-white hover:text-neutral-700 hover:bg-gray-100 cursor-pointer transition-all duration-200"
          >
            <Menu size={16} />
          </button>
          <h1 className="ml-2 lg:ml-0 font-light text-white">Dashboard</h1>
        </div>

        <div className="flex items-center space-x-4">
          <button className="p-2 rounded-full bg-neutral-700 text-white hover:bg-white hover:text-neutral-900 transition-all duration-200 cursor-pointer">
            <Settings size={18} />
          </button>
        </div>
      </div>
    </header>
  );
};

export default Header;
