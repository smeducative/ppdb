import { forwardRef, ReactNode } from "react";
import { cn } from "@/lib/utils";

export const BentoGrid = forwardRef<
  HTMLDivElement,
  {
    className?: string;
    children?: ReactNode;
  }
>(({ className, children }, ref) => {
  return (
    <div
      ref={ref}
      className={cn(
        "grid md:auto-rows-[18rem] grid-cols-1 md:grid-cols-3 gap-4 max-w-7xl mx-auto ",
        className
      )}
    >
      {children}
    </div>
  );
});

BentoGrid.displayName = "BentoGrid";

export const BentoGridItem = ({
  className,
  title,
  description,
  header,
  icon,
  badge,
  gradient,
}: {
  className?: string;
  title?: string | ReactNode;
  description?: string | ReactNode;
  header?: ReactNode;
  icon?: ReactNode;
  badge?: string;
  gradient?: string;
}) => {
  return (
    <div
      className={cn(
        "row-span-1 rounded-3xl group/bento hover:shadow-xl transition duration-200 shadow-input dark:shadow-none p-4 dark:bg-black dark:border-white/[0.2] bg-white border border-transparent justify-between flex flex-col space-y-4",
        className
      )}
    >
      {header}
      <div className="group-hover/bento:translate-x-2 transition duration-200">
        <div className="flex items-center justify-between mb-2">
            <div className={cn("p-2 rounded-lg bg-gradient-to-br", gradient)}>
                {icon}
            </div>
            {badge && (
                <span className="px-2 py-1 bg-green-100 dark:bg-green-900/20 text-green-700 dark:text-green-400 text-[10px] font-bold rounded-full">
                    {badge}
                </span>
            )}
        </div>
        <div className="font-bold text-foreground mb-2 mt-2">
          {title}
        </div>
        <div className="font-normal text-muted-foreground text-xs">
          {description}
        </div>
      </div>
    </div>
  );
};
